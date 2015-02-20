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

        /**
         * Get shipping zones
         *
         * @return array
         */
        public function getZones() {
            $sql = "SELECT `z`.*,
                    (
                      SELECT GROUP_CONCAT(`country_code` ORDER BY `country_code` ASC SEPARATOR ', ')
                      FROM `{$this->tableZonesCountryCodes}`
                      WHERE `zone` = `z`.`id`
                    ) AS `country_codes`
                    FROM `{$this->tableZones}` `z`
                    ORDER BY `z`.`name` ASC";
            return $this->db->fetchAll($sql);
        }

        /**
         * Get shipping types
         *
         * @param int $local
         * @return array
         */
        public function getTypes($local = 0) {
            $sql = "SELECT *
                    FROM `{$this->tableShippingType}`
                    WHERE `local` = " . intval($local) . "
                    ORDER BY `order` ASC";
            return $this->db->fetchAll($sql);
        }

        /**
         * Add a new shipping type
         *
         * @param null $params
         * @return bool
         */
        public function addType($params = null) {
            if (!empty($params)) {
                $params['local'] = !empty($params['local']) ? 1 : 0;
                $last = $this->getLastType($params['local']);
                $params['order'] = !empty($last) ? $last['order'] + 1 : 1;
                $this->db->prepareInsert($params);
                return $this->db->insert($this->tableShippingType);
            }
            return false;
        }

        /**
         * Delete a shipping type by id
         *
         * @param null $id
         * @return bool|resource
         */
        public function removeType($id = null) {
            if (!empty($id)) {
                $sql = "DELETE FROM `{$this->tableShippingType}`
                        WHERE `id` = " . intval($id);
                if ($this->db->query($sql)) {
                    $sql = "DELETE FROM `{$this->tableShipping}`
                            WHERE `type` = " . intval($id);
                    return $this->db->query($sql);
                }
                return false;
            }
            return false;
        }

        /**
         * Get last shipping type
         *
         * @param int $local
         * @return mixed
         */
        private function getLastType($local = 0) {
            $sql = "SELECT `order`
                    FROM `{$this->tableShippingType}`
                    WHERE `local` = {$local}
                    ORDER BY `order` DESC
                    LIMIT 0, 1";
            return $this->db->fetchOne($sql);
        }
    }