<?php

    /**
     * Class Shipping
     */
    class Shipping extends Application {

        // Database table names
        private $tableShipping = 'shipping';
        private $tableShippingType = 'shipping_type';
        private $tableZones = 'zones';
        private $tableZonesCountryCodes = 'zones_country_codes';
        // Basket instance
        public $objBasket;

        /**
         * Constructor
         *
         * @param null $objBasket
         */
        public function __construct($objBasket = null) {
            parent::__construct();
            $this->objBasket = is_object($objBasket) ? $objBasket : new Basket();
        }

        /**
         * Get a shipping type by id
         *
         * @param null $id
         * @return mixed|null
         */
        public function getType($id = null) {
            if (!empty($id)) {
                $sql = "SELECT *
                        FROM `{$this->tableShippingType}`
                        WHERE `id` = " . intval($id);
                return $this->db->fetchOne($sql);
            }
            return null;
        }
    }