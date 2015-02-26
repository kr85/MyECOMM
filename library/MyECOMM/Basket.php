<?php

/**
 * Class Basket
 */
class Basket {

    // Catalog instance
    public $instanceCatalog;

    // Empty basket variable
    public $emptyBasket;

    // Tax rate variable
    public $taxRate;

    // Number of items variable
    public $numberOfItems;

    // Sub-total amount variable
    public $subTotal;

    // Tax variable
    public $tax;

    // Total amount variable
    public $total;

    // The total weight of all products in the basket
    public $weight;

    // A list with the products' weight
    private $weightList;

    // The final shipping type
    public $finalShippingType;

    // The final shipping cost
    public $finalShippingCost;

    // The final subtotal amount
    public $finalSubtotal;

    // The final tax amount
    public $finalTax;

    // The final total amount
    public $finalTotal;

    public $user;

    /**
     * Constructor
     *
     * @param null $user
     */
    public function __construct($user = null) {

        // Check if a user was passed
        if (!empty($user)) {
            $this->user = $user;
        }

        // Instantiate catalog class
        $this->instanceCatalog = new Catalog();
        $this->emptyBasket = empty($_SESSION['basket']) ?
            true :
            false;

        if (!empty($this->user) &&
            ($this->user['country'] == COUNTRY_LOCAL || INTERNATIONAL_VAT)) {
            // Instantiate business class and get the tax rate
            $objBusiness = new Business();
            $this->taxRate = $objBusiness->getTaxRate();
        } else {
            $this->taxRate = 0;
        }

        $this->noItems();
        $this->subTotal();
        $this->tax();
        $this->total();
        $this->process();
    }

    /**
     * Get the number of items
     */
    public function noItems() {

        $value = 0;
        if (!$this->emptyBasket) {
            foreach ($_SESSION['basket'] as $key => $basket) {
                $value += $basket['quantity'];
            }
        }
        $this->numberOfItems = $value;
    }

    /**
     * Get the subtotal
     */
    public function subTotal() {

        $value = 0;
        if (!$this->emptyBasket) {
            foreach ($_SESSION['basket'] as $key => $basket) {
                $product = $this->instanceCatalog->getProduct($key);
                //var_dump($product);
                $value += ($basket['quantity'] * $product['price']);
                $this->weightList[] = ($basket['quantity'] * $product['weight']);
            }
        }
        if (!is_array($this->weightList)) {
            $this->weightList = Helper::makeArray($this->weightList);
        }
        $this->weight = array_sum($this->weightList);
        $this->subTotal = round($value, 2);
    }

    /**
     * Get the tax
     */
    public function tax() {

        $value = 0;
        if (!$this->emptyBasket) {
            $value = ($this->taxRate * ($this->subTotal / 100));
        }
        $this->tax = round($value, 2);
    }

    /**
     * Get the total
     */
    public function total() {

        $this->total = round(($this->subTotal + $this->tax), 2);
    }

    /**
     * Get active button for basket
     *
     * @param $sessionId
     * @return string
     */
    public static function activeButton($sessionId) {

        if (isset($_SESSION['basket'][$sessionId])) {
            $id = 0;
            $label = "Remove from basket";
        } else {
            $id = 1;
            $label = "Add to basket";
        }

        $out = "<a href=\"\" class=\"add_to_basket";
        $out .= $id == 0 ?
            " red" :
            null;
        $out .= "\" rel=\"";
        $out .= $sessionId . "_" . $id;
        $out .= "\">{$label}</a>";

        return $out;
    }

    /**
     * Calculate the total of an item by price and quantity
     *
     * @param null $price
     * @param null $quantity
     * @return float
     */
    public function itemTotal($price = null, $quantity = null) {

        if (!empty($price) && !empty($quantity)) {
            return round(($price * $quantity), 2);
        }

        return false;
    }

    /**
     * Get the remove item button for the basket
     *
     * @param null $id
     * @return string
     */
    public static function removeButton($id = null) {

        if (!empty($id)) {
            if (isset($_SESSION['basket'][$id])) {
                $out = "<a href=\"\" class=\"remove_basket red";
                $out .= "\" rel=\"{$id}\">Remove</a>";

                return $out;
            }
        }

        return false;
    }

    /**
     * Add shipping to the basket/session
     *
     * @param null $shipping
     * @return bool
     */
    public function addShipping($shipping = null) {
        // Check if shipping passed
        if (!empty($shipping)) {
            Session::setSession('shipping_id', $shipping['id']);
            Session::setSession('shipping_cost', $shipping['cost']);
            Session::setSession('shipping_type', $shipping['name']);
            $this->process();
            return true;
        }
        return false;
    }

    /**
     * Clear the shipping
     */
    public function clearShipping() {
        // Clear the sessions
        Session::clear('id');
        Session::clear('shipping_cost');
        Session::clear('shipping_type');

        // Clear the parameters
        $this->finalShippingType = null;
        $this->finalShippingCost = null;
        $this->finalSubtotal = null;
        $this->finalTax = null;
        $this->finalTotal = null;
    }

    /**
     * Process helper
     */
    private function process() {
        $this->finalShippingType = Session::getSession('shipping_type');
        $this->finalShippingCost = Session::getSession('shipping_cost');
        $this->finalSubtotal = round(($this->subTotal + $this->finalShippingCost), 2);
        $this->finalTax = round(($this->taxRate * ($this->finalSubtotal / 100)), 2);
        $this->finalTotal = round(($this->finalSubtotal + $this->finalTax), 2);
    }
}