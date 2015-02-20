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
         * Update shipping type
         *
         * @param null $params
         * @param null $id
         * @return bool|resource
         */
        public function updateType($params = null, $id = null) {
            if (!empty($params) && !empty($id)) {
                $this->db->prepareUpdate($params);
                return $this->db->update($this->tableShippingType, $id);
            }
            return false;
        }

        /**
         * Set a default shipping type
         *
         * @param null $id
         * @param int $local
         * @return bool|resource
         */
        public function setTypeDefault($id = null, $local = 0) {
            if (!empty($id)) {
                $sql = "UPDATE `{$this->tableShippingType}`
                        SET `default` = 0
                        WHERE `local` = {$local}
                        AND `id` != " . intval($id);
                if ($this->db->query($sql)) {
                    $sql = "UPDATE `{$this->tableShippingType}`
                            SET `default` = 1
                            WHERE `local` = {$local}
                            AND `id` = " . intval($id);
                    return $this->db->query($sql);
                }
                return false;
            }
            return false;
        }

        /**
         * Duplicate a shipping type
         *
         * @param null $id
         * @return bool
         */
        public function duplicateType($id = null) {
            if (!empty($id)) {
                $type = $this->getType($id);
                if (!empty($type)) {
                    $last = $this->getLastType($type['local']);
                    $order = (!empty($last)) ? $last['order'] + 1 : 1;
                    $this->db->prepareInsert([
                        'name' => $type['name'] . ' copy',
                        'order' => $order,
                        'local' => $type['local'],
                        'active' => 0
                    ]);
                    if ($this->db->insert($this->tableShippingType)) {
                        $this->db->insertKeys = [];
                        $this->db->insertValues = [];
                        $newId = $this->db->id;
                        $sql = "SELECT *
                                FROM `{$this->tableShipping}`
                                WHERE `type` = {$id}";
                        $list = $this->db->fetchOne($sql);
                        if (!empty($list)) {
                            foreach ($list as $row) {
                                $this->db->prepareInsert([
                                    'type' => $newId,
                                    'zone' => $row['zone'],
                                    'country' => $row['country'],
                                    'weight' => $row['weight'],
                                    'cost' => $row['cost']
                                ]);
                            }
                            $this->db->insert($this->tableShipping);
                            $this->db->insertKeys = [];
                            $this->db->insertValues = [];
                        }
                        return true;
                    }
                    return false;
                }
                return false;
            }
            return false;
        }

        /**
         * Get a zone by id
         *
         * @param null $id
         * @return bool|mixed
         */
        public function getZoneById($id = null) {
            if (!empty($id)) {
                $sql = "SELECT *
                        FROM `{$this->tableZones}`
                        WHERE `id` = " . intval($id);
                return $this->db->fetchOne($sql);
            }
            return false;
        }

        /**
         *
         *
         * @param null $typeId
         * @param null $zoneId
         * @return array|bool
         */
        public function getShippingByTypeZone($typeId = null, $zoneId = null) {
            if (!empty($typeId) && !empty($zoneId)) {
                $sql = "SELECT `s`.*,
                        IF (
                            (
                              SELECT COUNT(`weight`)
                              FROM `{$this->tableShipping}`
                              WHERE `type` = `s`.`type`
                              AND `zone` = `s`.`zone`
                              AND `weight` < `s`.`weight`
                              ORDER BY `weight` DESC
                              LIMIT 0, 1
                            ) > 0,
                            (
                              SELECT `weight`
                              FROM `{$this->tableShipping}`
                              WHERE `type` = `s`.`type`
                              AND `zone` = `s`.`zone`
                              AND `weight` < `s`.`weight`
                              ORDER BY `weight` DESC
                              LIMIT 0, 1
                            ) + 0.01,
                            0
                        ) AS `weight_from`
                        FROM `{$this->tableShipping}` `s`
                        WHERE `s`.`type` = " . intval($typeId) . "
                        AND `s`.`zone` = " . intval($zoneId) . "
                        ORDER BY `s`.`weight` ASC";
                return $this->db->fetchAll($sql);
            }
            return false;
        }

        /**
         * Check if a shipping rate is duplicate
         *
         * @param null $typeId
         * @param null $zoneId
         * @param null $weight
         * @return bool
         */
        public function isDuplicateLocal($typeId = null, $zoneId = null, $weight = null) {
            if (!empty($typeId) && !empty($zoneId) && !empty($weight)) {
                $sql = "SELECT *
                        FROM `{$this->tableShipping}`
                        WHERE `type` = " . intval($typeId) . "
                        AND `zone` = " . intval($zoneId) . "
                        AND `weight` = '" . floatval($weight) . "'";
                $result = $this->db->fetchOne($sql);
                return (!empty($result)) ? true : false;
            }
            return false;
        }

        /**
         * Add new shipping rate
         *
         * @param null $params
         * @return bool
         */
        public function addShipping($params = null) {
            if (!empty($params)) {
                $this->db->prepareInsert($params);
                return $this->db->insert($this->tableShipping);
            }
            return false;
        }

        /**
         * Get a shipping rate by id, type id and zone id
         *
         * @param null $id
         * @param null $typeId
         * @param null $zoneId
         * @return bool|mixed
         */
        public function getShippingByIdTypeZone($id = null, $typeId = null, $zoneId = null) {
            if (!empty($id) && !empty($typeId) && !empty($zoneId)) {
                $sql = "SELECT *
                        FROM `{$this->tableShipping}`
                        WHERE `id` = " . intval($id) . "
                        AND `type` = " . intval($typeId) . "
                        AND `zone` = " . intval($zoneId);
                return $this->db->fetchOne($sql);
            }
            return false;
        }

        /**
         * Remove a shipping rate by id
         *
         * @param null $id
         * @return bool|resource
         */
        public function removeShipping($id = null) {
            if (!empty($id)) {
                $sql = "DELETE FROM `{$this->tableShipping}`
                        WHERE `id` = " . intval($id);
                return $this->db->query($sql);
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