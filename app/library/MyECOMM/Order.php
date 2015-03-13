<?php namespace MyECOMM;

use \PDOException;

/**
 * Class Order
 */
class Order extends Application {

    /**
     * @var string Database orders table
     */
    protected $tableOrders = 'orders';

    /**
     * @var string Database orders items table
     */
    protected $tableOrdersItems = 'orders_items';

    /**
     * @var string Database statuses table
     */
    protected $tableStatuses = 'statuses';

    /**
     * @var string Database countries table
     */
    protected $tableCountries = 'countries';

    /**
     * @var string Database products table
     */
    protected $tableProducts = 'products';

    /**
     * @var array Array of basket items
     */
    private $basket = [];

    /**
     * @var array Array of items
     */
    private $items  = [];

    /**
     * Create a new order sql query
     *
     * @param null $user
     * @return bool
     */
    public function createOrder($user = null) {
        $this->getItems();
        if ($this->isUserAndItemsValid($user)) {
            $objBasket = new Basket($user);
            $objBusiness = new Business();
            $business = $objBusiness->getOne(Business::BUSINESS_ID);
            // Order parameters
            $params = [
                'tax_number'     => $business['tax_number'],
                'client'         => $user['id'],
                'first_name'     => $user['first_name'],
                'last_name'      => $user['last_name'],
                'address_1'      => $user['address_1'],
                'address_2'      => $user['address_2'],
                'city'           => $user['city'],
                'state'          => $user['state'],
                'zip_code'       => $user['zip_code'],
                'country'        => $user['country'],
                'shipping_type'  => $objBasket->finalShippingType,
                'shipping_cost'  => $objBasket->finalShippingCost,
                'tax_rate'       => $objBasket->taxRate,
                'tax'            => $objBasket->finalTax,
                'subtotal_items' => $objBasket->subTotal,
                'subtotal'       => $objBasket->finalSubtotal,
                'total'          => $objBasket->finalTotal,
                'date'           => Helper::setDate(),
                'token'          => date('YmdHis').mt_rand().md5(time())
            ];
            // Shipping information
            if ($user['same_address'] == 1) {
                $params['shipping_address_1'] = $user['address_1'];
                $params['shipping_address_2'] = $user['address_2'];
                $params['shipping_city']      = $user['city'];
                $params['shipping_state']     = $user['state'];
                $params['shipping_zip_code']  = $user['zip_code'];
                $params['shipping_country']   = $user['country'];
            } else {
                $params['shipping_address_1'] = $user['shipping_address_1'];
                $params['shipping_address_2'] = $user['shipping_address_2'];
                $params['shipping_city']      = $user['shipping_city'];
                $params['shipping_state']     = $user['shipping_state'];
                $params['shipping_zip_code']  = $user['shipping_zip_code'];
                $params['shipping_country']   = $user['shipping_country'];
            }

            try {
                // Begin the transaction
                $this->Db->beginTransaction();
                // Insert the into table
                $this->Db->insertTransaction($this->tableOrders, $params);
                // Get record id
                $this->id = $this->Db->id;
                // For each item insert it into the table
                foreach ($this->items as $item) {
                    $this->Db->insertTransaction($this->tableOrdersItems, [
                        'order'   => $this->id,
                        'product' => $item['id'],
                        'price'   => $item['price'],
                        'qty'     => $this->basket[$item['id']]['quantity']
                    ]);
                }
                // Commit the transaction
                $this->Db->commit();
                return true;
            } catch (PDOException $e) {
                $this->Db->rollBack();
                return false;
            }
        }
        return false;
    }

    /**
     * Check if the user and the items are valid
     *
     * @param null $user
     * @return bool
     */
    private function isUserAndItemsValid($user = null) {
        return (!empty($user) && !empty($this->items));
    }

    /**
     * Get all items from the session
     */
    public function getItems() {
        $this->basket = Session::getSession('basket');
        if (!empty($this->basket)) {
            $objCatalog = new Catalog();
            foreach ($this->basket as $key => $value) {
                $this->items[$key] = $objCatalog->getProduct($key);
            }
        }
    }

    /**
     * Get a specific order by id
     *
     * @param null $id
     * @return mixed
     */
    public function getOrder($id = null) {
        $id = (!empty($id)) ? $id : $this->id;
        $sql = "SELECT `o`.*,
                DATE_FORMAT(`o`.`date`, '%D %M %Y %r') AS `date_formatted`,
                CONCAT_WS(' ', `o`.`first_name`, `o`.`last_name`) AS `full_name`,
                IF (
                  `o`.`address_2` != '',
                  CONCAT_WS(', ', `o`.`address_1`, `o`.`address_2`),
                  `o`.`address_1`
                ) AS `address`,
                IF (
                  `o`.`shipping_address_2` != '',
                  CONCAT_WS(', ', `o`.`shipping_address_1`, `o`.`shipping_address_2`),
                  `o`.`shipping_address_1`
                ) AS `shipping_address`,
                (
                  SELECT `name`
                  FROM `{$this->tableCountries}`
                  WHERE `id` = `o`.`country`
                ) AS `country_name`,
                (
                  SELECT `name`
                  FROM `{$this->tableCountries}`
                  WHERE `id` = `o`.`shipping_country`
                ) AS `shipping_country_name`
                FROM `{$this->tableOrders}` `o`
                WHERE `o`.`id` = ?";
        return $this->Db->fetchOne($sql, $id);
    }

    /**
     * Get order by id and last name
     *
     * @param null $id
     * @param null $lastName
     * @return mixed
     */
    public function getOrderByIdLastName($id = null, $lastName = null) {
        $id = (!empty($id)) ? $id : $this->id;
        $sql = "SELECT `o`.*,
                DATE_FORMAT(`o`.`date`, '%D %M %Y %r') AS `date_formatted`,
                CONCAT_WS(' ', `o`.`first_name`, `o`.`last_name`) AS `full_name`,
                IF (
                  `o`.`address_2` != '',
                  CONCAT_WS(', ', `o`.`address_1`, `o`.`address_2`),
                  `o`.`address_1`
                ) AS `address`,
                IF (
                  `o`.`shipping_address_2` != '',
                  CONCAT_WS(', ', `o`.`shipping_address_1`, `o`.`shipping_address_2`),
                  `o`.`shipping_address_1`
                ) AS `shipping_address`,
                (
                  SELECT `name`
                  FROM `{$this->tableCountries}`
                  WHERE `id` = `o`.`country`
                ) AS `country_name`,
                (
                  SELECT `name`
                  FROM `{$this->tableCountries}`
                  WHERE `id` = `o`.`shipping_country`
                ) AS `shipping_country_name`
                FROM `{$this->tableOrders}` `o`
                WHERE `o`.`id` = ?
                AND `o`.`last_name` = ?";
        return $this->Db->fetchOne($sql, [$id, $lastName]);
    }

    /**
     * Get a specific order by token
     *
     * @param null $token
     * @return mixed|null
     */
    public function getOrderByToken($token = null) {
        if (!empty($token)) {
            $sql = "SELECT `o`.*,
                DATE_FORMAT(`o`.`date`, '%D %M %Y %r') AS `date_formatted`,
                CONCAT_WS(' ', `o`.`first_name`, `o`.`last_name`) AS `full_name`,
                IF (
                  `o`.`address_2` != '',
                  CONCAT_WS(', ', `o`.`address_1`, `o`.`address_2`),
                  `o`.`address_1`
                ) AS `address`,
                IF (
                  `o`.`shipping_address_2` != '',
                  CONCAT_WS(', ', `o`.`shipping_address_1`, `o`.`shipping_address_2`),
                  `o`.`shipping_address_1`
                ) AS `shipping_address`,
                (
                  SELECT `name`
                  FROM `{$this->tableCountries}`
                  WHERE `id` = `o`.`country`
                ) AS `country_name`,
                (
                  SELECT `name`
                  FROM `{$this->tableCountries}`
                  WHERE `id` = `o`.`shipping_country`
                ) AS `shipping_country_name`
                FROM `{$this->tableOrders}` `o`
                WHERE `o`.`token` = ?";
            return $this->Db->fetchOne($sql, $token);
        }
        return null;
    }

    /**
     * Get all items of a specific order
     *
     * @param null $id
     * @return array
     */
    public function getOrderItems($id = null) {
        $id = !empty($id) ? $id : $this->id;
        $sql = "SELECT `i`.*, `p`.`name`,
                  (`i`.`price` * `i`.`qty`) AS `price_total`
                FROM `{$this->tableOrdersItems}` `i`
                LEFT JOIN `{$this->tableProducts}` `p`
                  ON `i`.`product` = `p`.`id`
                WHERE `i`.`order` = ?";
        return $this->Db->fetchAll($sql, $id);
    }

    /**
     * Approve the order and update its status
     *
     * @param null $data
     * @param null $result
     * @return bool
     */
    public function approve($data = null, $result = null) {
        if ($this->isApprovalValid($data, $result)) {
            // PayPal payment status
            $active = ($data['payment_status'] == 'Completed') ? 1 : 0;
            // An array to hold the IPN response
            $out = [];
            // Reassign the data received from PayPal
            foreach ($data as $key => $value) {
                $out[] = "{$key} : {$value}";
            }
            // IPN response
            $out = implode("\n", $out);
            // Update the order with the response from PayPal
            return $this->Db->update($this->tableOrders, [
                'pp_status' => $active,
                'txn_id' => $data['txn_id'],
                'payment_status' => $data['payment_status'],
                'ipn' => $out,
                'response' => $result
            ], $data['custom'], 'token');
        }
        return false;
    }

    /**
     * Check if the approve parameters are valid
     *
     * @param null $data
     * @param null $result
     * @return bool
     */
    private function isApprovalValid($data = null, $result = null) {
        return (
            !empty($data) &&
            !empty($result) &&
            array_key_exists('txn_id', $data) &&
            array_key_exists('payment_status', $data) &&
            array_key_exists('custom', $data)
        );
    }

    /**
     * Get all orders of a client
     *
     * @param null $clientId
     * @return array
     */
    public function getClientOrders($clientId = null) {
        if (!empty($clientId)) {
            $sql = "SELECT *
                    FROM `{$this->tableOrders}`
                    WHERE `client` = ?
                    ORDER BY `date` DESC";
            return $this->Db->fetchAll($sql, $clientId);
        }
        return null;
    }

    /**
     * Get the status by id
     *
     * @param null $id
     * @return mixed
     */
    public function getStatus($id = null) {
        if (!empty($id)) {
            $sql = "SELECT *
                    FROM `{$this->tableStatuses}`
                    WHERE `id` = ?";
            return $this->Db->fetchOne($sql, $id);
        }
        return null;
    }

    /**
     * Get all orders by search criteria if available
     *
     * @param null $search
     * @return array
     */
    public function getAllOrders($search = null) {
        $params = [];
        $sql = "SELECT *
                FROM `$this->tableOrders`";
        if(!empty($search)) {
            $params[] = $search;
            $sql .= " WHERE `id` = ?";
        }
        $sql .= " ORDER BY `date` DESC";
        return $this->Db->fetchAll($sql, $params);
    }

    /**
     * Update an existing order
     *
     * @param null $id
     * @param null $data
     * @return bool|resource
     */
    public function updateOrder($id = null, $data = null) {
        if ($this->isUpdateOrderValid($id, $data)) {
            return $this->Db->update($this->tableOrders, [
                'status' => $data['status'],
                'notes'  => $data['notes']
            ], $id);
        }
        return false;
    }

    /**
     * Check if the update order parameters are valid
     *
     * @param null $id
     * @param null $data
     * @return bool
     */
    private function isUpdateOrderValid($id = null, $data = null) {
        return (
            !empty($id) &&
            !empty($data) &&
            is_array($data) &&
            array_key_exists('status', $data) &&
            array_key_exists('notes', $data)
        );
    }

    /**
     * Get all statuses
     *
     * @return array
     */
    public function getStatuses() {
        $sql = "SELECT *
                FROM `$this->tableStatuses`
                ORDER BY `id` ASC";
        return $this->Db->fetchAll($sql);
    }

    /**
     * Delete a order by id
     *
     * @param null $id
     * @return bool|mixed
     */
    public function removeOrder($id = null) {
        return $this->Db->delete($this->tableOrders, $id);
    }
}