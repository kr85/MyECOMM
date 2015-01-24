<?php

/**
 * Class Order
 */
class Order extends Application
{
    // Database table names
    private $tableOrders = 'orders';
    private $tableOrdersItems = 'orders_items';
    private $tableStatuses = 'statuses';

    private $basket = [];
    private $items = [];

    private $fields = [];
    private $values = [];

    private $id = null;

    /**
     * Create a new order sql query
     *
     * @return bool
     */
    public function createOrder()
    {
        $this->getItems();

        if (!empty($this->items))
        {
            $objUser = new User();
            $user = $objUser->getUser(Session::getSession(Login::$loginFront));

            if (!empty($user))
            {
                $objBasket = new Basket();

                $this->fields[] = 'client';
                $this->values[] = $this->db->escape($user['id']);

                $this->fields[] = 'tax_rate';
                $this->values[] = $this->db->escape($objBasket->taxRate);

                $this->fields[] = 'tax';
                $this->values[] = $this->db->escape($objBasket->tax);

                $this->fields[] = 'subtotal';
                $this->values[] = $this->db->escape($objBasket->subTotal);

                $this->fields[] = 'total';
                $this->values[] = $this->db->escape($objBasket->total);

                $this->fields[] = 'date';
                $this->values[] = Helper::setDate();

                $sql = "INSERT INTO `{$this->tableOrders}` (`";
                $sql .= implode("`, `", $this->fields);
                $sql .= "`) VALUES ('";
                $sql .= implode("', '", $this->values);
                $sql .= "')";

                $this->db->query($sql);
                $this->id = $this->db->lastId();

                if (!empty($this->id))
                {
                    $this->fields = [];
                    $this->values = [];

                    return $this->addItems($this->id);

                }
            }

            return false;
        }

        return false;
    }

    /**
     * Add items to the database sql query
     *
     * @param null $orderId
     * @return bool
     */
    public function addItems($orderId = null)
    {
        if (!empty($orderId))
        {
            $errors = [];

            foreach ($this->items as $item)
            {
                $sql = "INSERT INTO `{$this->tableOrdersItems}`
                          (`order`, `product`, `price`, `qty`)
                          VALUES ('{$orderId}',
                                  '".$item['id']."',
                                  '".$item['price']."',
                                  '".$this->basket[$item['id']]['quantity']."')";

                if (!$this->db->query($sql))
                {
                    $errors[] = $sql;
                }
            }

            return empty($errors) ? true : false;
        }

        return false;
    }

    /**
     * Get all items from the session
     */
    public function getItems()
    {
        $this->basket = Session::getSession('basket');

        if (!empty($this->basket))
        {
            $objCatalog = new Catalog();

            foreach ($this->basket as $key => $value)
            {
                $this->items[$key] = $objCatalog->getProduct($key);
            }
        }
    }

    /**
     * Get a specific order
     *
     * @param null $id
     * @return mixed
     */
    public function getOrder($id = null)
    {
        $id = !empty($id) ? $id : $this->id;

        $sql = "SELECT * FROM `{$this->tableOrders}`
                  WHERE `id` = '".$this->db->escape($id)."'";

        return $this->db->fetchOne($sql);
    }

    /**
     * Get all items of a specific order
     *
     * @param null $id
     * @return array
     */
    public function getOrderItems($id = null)
    {
        $id = !empty($id) ? $id : $this->id;

        $sql = "SELECT * FROM `{$this->tableOrdersItems}`
                  WHERE `order` = '".$this->db->escape($id)."'";

        return $this->db->fetchAll($sql);
    }

    /**
     * Approve the order and update its status
     *
     * @param null $data
     * @param null $result
     * @return bool
     */
    public function approve($data = null, $result = null)
    {
        if (!empty($data) && !empty($result))
        {
            if (array_key_exists('txn_id', $data) &&
                array_key_exists('payment_status', $data) &&
                array_key_exists('custom', $data))
            {
                $active = $data['payment_status'] == 'Completed' ? 1 : 0;

                $out = [];

                foreach ($data as $key => $value)
                {
                    $out[] = "{$key} : {$value}";
                }

                $out = implode("\n", $out);

                $errors = [];

                $sql = "UPDATE `{$this->tableOrders}`
                     SET `pp_status` = '".$this->db->escape($active)."',
                     `txn_id` = '".$this->db->escape($data['txn_id'])."',
                     `payment_status` = '".$this->db->escape($data['payment_status'])."'
                     `ipn` = '".$this->db->escape($out)."'
                     `response` = '".$this->db->escape($result)."'
                     WHERE `id` = '".$this->db->escape($data['custom'])."'";

                if(!$this->db->query($sql))
                {
                    Helper::addToErrorsLog('Update_approve_query_failed', null);
                    $errors[] = $sql;
                }

                Helper::addToErrorsLog(null, $sql);
                Helper::addToErrorsLog('After_approve_query', null);
                return empty($errors) ? true : false;
            }

            Helper::addToErrorsLog('txn_id_payment_status_or_custom_do_not_exist', null);
            return false;
        }

        Helper::addToErrorsLog('Data_and_result_for_approve_are_empty', null);
        return false;
    }
}