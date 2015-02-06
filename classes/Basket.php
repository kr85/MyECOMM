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

        /**
         * Constructor
         */
        public function __construct() {

            // Instantiate catalog class
            $this->instanceCatalog = new Catalog();
            $this->emptyBasket = empty($_SESSION['basket']) ?
                true :
                false;

            // Instantiate business class
            $objBusiness = new Business();
            $this->taxRate = $objBusiness->getTaxRate();

            $this->noItems();
            $this->subTotal();
            $this->tax();
            $this->total();
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
                    $value += ($basket['quantity'] * $product['price']);
                }
            }
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
    }