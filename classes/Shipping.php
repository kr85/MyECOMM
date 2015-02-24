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
         * Get a post code by id and zone id
         *
         * @param null $id
         * @param null $zoneId
         * @return mixed|null
         */
        public function getPostCode($id = null, $zoneId = null) {
            if (!empty($id) && !empty($zoneId)) {
                $sql = "SELECT *
                        FROM `{$this->tableZonesCountryCodes}`
                        WHERE `id` = " . intval($id) . "
                        AND `zone` = " . intval($zoneId);
                return $this->db->fetchOne($sql);
            }
            return null;
        }

        /**
         * Get all post codes of the a zone by zone id
         *
         * @param null $zoneId
         * @return array|null
         */
        public function getPostCodes($zoneId = null) {
            if (!empty($zoneId)) {
                $sql = "SELECT *
                        FROM `{$this->tableZonesCountryCodes}`
                        WHERE `zone` = " . intval($zoneId) . "
                        ORDER BY `country_code` ASC";
                return $this->db->fetchAll($sql);
            }
            return null;
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
         * Add a new zone
         *
         * @param null $params
         * @return bool
         */
        public function addZone($params = null) {
            if (!empty($params)) {
                $this->db->prepareInsert($params);
                return $this->db->insert($this->tableZones);
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
         * Remove a zone by id
         *
         * @param null $id
         * @return bool|resource
         */
        public function removeZone($id = null) {
            if (!empty($id)) {
                $sql = "DELETE FROM `{$this->tableZones}`
                        WHERE `id` = " . intval($id);
                return $this->db->query($sql);
            }
            return false;
        }

        /**
         * Update a shipping type
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
         * Update a zone
         *
         * @param null $params
         * @param null $id
         * @return bool
         */
        public function updateZone($params = null, $id = null) {
            if (!empty($params) && !empty($id)) {
                $this->db->prepareUpdate($params);
                return $this->db->update($this->tableZones, $id);
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
            return null;
        }

        /**
         * Get a shipping rates by type id and zone id
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
            return null;
        }

        /**
         * Get shipping rates by type id and country id
         *
         * @param null $typeId
         * @param null $countryId
         * @return array|bool
         */
        public function getShippingByTypeCountry($typeId = null, $countryId = null) {
            if (!empty($typeId) && !empty($countryId)) {
                $sql = "SELECT `s`.*,
                        IF (
                            (
                              SELECT COUNT(`weight`)
                              FROM `{$this->tableShipping}`
                              WHERE `type` = `s`.`type`
                              AND `country` = `s`.`country`
                              AND `weight` < `s`.`weight`
                              ORDER BY `weight` DESC
                              LIMIT 0, 1
                            ) > 0,
                            (
                              SELECT `weight`
                              FROM `{$this->tableShipping}`
                              WHERE `type` = `s`.`type`
                              AND `country` = `s`.`country`
                              AND `weight` < `s`.`weight`
                              ORDER BY `weight` DESC
                              LIMIT 0, 1
                            ) + 0.01,
                            0
                        ) AS `weight_from`
                        FROM `{$this->tableShipping}` `s`
                        WHERE `s`.`type` = " . intval($typeId) . "
                        AND `s`.`country` = " . intval($countryId) . "
                        ORDER BY `s`.`weight` ASC";
                return $this->db->fetchAll($sql);
            }
            return null;
        }

        /**
         * Check if a local shipping rate is duplicate
         *
         * @param null $typeId
         * @param null $zoneId
         * @param null $weight
         * @return bool
         */
        public function isDuplicateLocal(
            $typeId = null, $zoneId = null, $weight = null
        ) {
            if (!empty($typeId) && !empty($zoneId) && !empty($weight)) {
                $sql = "SELECT *
                        FROM `{$this->tableShipping}`
                        WHERE `type` = " . intval($typeId) . "
                        AND `zone` = " . intval($zoneId) . "
                        AND `weight` = '" . floatval($weight) . "'";
                $result = $this->db->fetchOne($sql);
                return (!empty($result)) ? true : false;
            }
            return true;
        }

        /**
         * Check if a international shipping rate is duplicate
         *
         * @param null $typeId
         * @param null $countryId
         * @param null $weight
         * @return bool
         */
        public function isDuplicateInternational(
            $typeId = null, $countryId = null, $weight = null
        ) {
            if (!empty($typeId) && !empty($countryId) && !empty($weight)) {
                $sql = "SELECT *
                        FROM `{$this->tableShipping}`
                        WHERE `type` = " . intval($typeId) . "
                        AND `country` = " . intval($countryId) . "
                        AND `weight` = '" . floatval($weight) . "'";
                $result = $this->db->fetchOne($sql);
                return (!empty($result)) ? true : false;
            }
            return true;
        }

        /**
         * Check if a post/country code is duplicate
         *
         * @param null $postCode
         * @return bool
         */
        public function isDuplicatePostCode($postCode = null) {
            if (!empty($postCode)) {
                $sql = "SELECT *
                        FROM `{$this->tableZonesCountryCodes}`
                        WHERE `country_code` = '" . $this->db->escape($postCode) . "'";
                $result = $this->db->fetchOne($sql);
                return (!empty($result)) ? true : false;
            }
            return true;
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
         * Add a new post/country code
         *
         * @param null $params
         * @return bool
         */
        public function addPostCode($params = null) {
            if (!empty($params)) {
                $this->db->prepareInsert($params);
                return $this->db->insert($this->tableZonesCountryCodes);
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
        public function getShippingByIdTypeZone(
            $id = null, $typeId = null, $zoneId = null
        ) {
            if (!empty($id) && !empty($typeId) && !empty($zoneId)) {
                $sql = "SELECT *
                        FROM `{$this->tableShipping}`
                        WHERE `id` = " . intval($id) . "
                        AND `type` = " . intval($typeId) . "
                        AND `zone` = " . intval($zoneId);
                return $this->db->fetchOne($sql);
            }
            return null;
        }

        /**
         * Get a shipping rate by id, type id and country id
         *
         * @param null $id
         * @param null $typeId
         * @param null $countryId
         * @return bool|mixed
         */
        public function getShippingByIdTypeCountry(
            $id = null, $typeId = null, $countryId = null
        ) {
            if (!empty($id) && !empty($typeId) && !empty($countryId)) {
                $sql = "SELECT *
                        FROM `{$this->tableShipping}`
                        WHERE `id` = " . intval($id) . "
                        AND `type` = " . intval($typeId) . "
                        AND `country` = " . intval($countryId);
                return $this->db->fetchOne($sql);
            }
            return null;
        }

        /**
         * Get the shipping options
         *
         * @param null $user
         * @return array|null
         */
        public function getShippingOptions($user = null) {
            if (!empty($user)) {
                $weight = $this->objBasket->weight;

                if (($user['same_address'] == 1 && $user['country'] == COUNTRY_LOCAL) ||
                    ($user['same_address'] == 0 && $user['shipping_country'] == COUNTRY_LOCAL)
                ) {
                    $postCode = ($user['same_address'] == 1) ?
                        $user['zip_code'] :
                        $user['shipping_zip_code'];
                    $postCode = strtoupper(Helper::alphaNumericalOnly($postCode));
                    $zone = $this->getZone($postCode);

                    if (empty($zone)) {
                        return null;
                    }

                    $zoneId = $zone['zone'];

                    $sql = "SELECT `t`.*,
                            IF (
                              {$weight} > (
                                SELECT MAX(`weight`)
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `zone` = {$zoneId}
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `zone` = {$zoneId}
                                ORDER BY `weight` DESC
                                LIMIT 0, 1
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `zone` = {$zoneId}
                                AND `weight` >= {$weight}
                                ORDER BY `weight` ASC
                                LIMIT 0, 1
                              )
                            ) AS `cost`
                            FROM `{$this->tableShippingType}` `t`
                            WHERE `t`.`active` = 1
                            AND `t`.`local` = 1
                            ORDER BY `t`.`order` ASC";
                    return $this->db->fetchAll($sql);
                } else {
                    $countryId = ($user['same_address'] == 1) ?
                        $user['country'] :
                        $user['shipping_country'];

                    $sql = "SELECT `t`.*,
                            IF (
                              {$weight} > (
                                SELECT MAX(`weight`)
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `country` = {$countryId}
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `country` = {$countryId}
                                ORDER BY `weight` DESC
                                LIMIT 0, 1
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `country` = {$countryId}
                                AND `weight` >= {$weight}
                                ORDER BY `weight` ASC
                                LIMIT 0, 1
                              )
                            ) AS `cost`
                            FROM `{$this->tableShippingType}` `t`
                            WHERE `t`.`active` = 1
                            AND `t`.`local` = 0
                            ORDER BY `t`.`order` ASC";
                    return $this->db->fetchAll($sql);
                }
            }
            return null;
        }

        /**
         * Get the default shipping type
         *
         * @param null $user
         * @return mixed|null
         */
        public function getDefault($user = null) {
            if (!empty($user)) {
                $countryId = ($user['same_address'] == 1) ?
                    $user['country'] :
                    $user['shipping_country'];

                if ($countryId == COUNTRY_LOCAL) {
                    $sql = "SELECT *
                            FROM `{$this->tableShippingType}`
                            WHERE `local` = 1
                            AND `active` = 1
                            AND `default` = 1";
                    return $this->db->fetchOne($sql);
                } else {
                    $sql = "SELECT *
                            FROM `{$this->tableShippingType}`
                            WHERE `local` = 0
                            AND `active` = 1
                            AND `default` = 1";
                    return $this->db->fetchOne($sql);
                }
            }
            return null;
        }

        /**
         * Get shipping
         *
         * @param null $user
         * @param null $shippingId
         * @return mixed|null
         */
        public function getShipping($user = null, $shippingId = null) {
            if (!empty($user) && !empty($shippingId)) {
                $weight = $this->objBasket->weight;

                if (($user['same_address'] == 1 && $user['country'] == COUNTRY_LOCAL) ||
                    ($user['same_address'] == 0 && $user['shipping_country'] == COUNTRY_LOCAL)
                ) {
                    $postCode = ($user['same_address'] == 1) ?
                        $user['zip_code'] :
                        $user['shipping_zip_code'];
                    $postCode = strtoupper(Helper::alphaNumericalOnly($postCode));
                    $zone = $this->getZone($postCode);

                    if (empty($zone)) {
                        return null;
                    }

                    $zoneId = $zone['zone'];

                    $sql = "SELECT `t`.*,
                            IF (
                              {$weight} > (
                                SELECT MAX(`weight`)
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `zone` = {$zoneId}
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `zone` = {$zoneId}
                                ORDER BY `weight` DESC
                                LIMIT 0, 1
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `zone` = {$zoneId}
                                AND `weight` >= {$weight}
                                ORDER BY `weight` ASC
                                LIMIT 0, 1
                              )
                            ) AS `cost`
                            FROM `{$this->tableShippingType}` `t`
                            WHERE `t`.`active` = 1
                            AND `t`.`local` = 1
                            AND `t`.`id` = {$shippingId}";
                    return $this->db->fetchOne($sql);
                } else {
                    $countryId = ($user['same_address'] == 1) ?
                        $user['country'] :
                        $user['shipping_country'];

                    $sql = "SELECT `t`.*,
                            IF (
                              {$weight} > (
                                SELECT MAX(`weight`)
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `country` = {$countryId}
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `country` = {$countryId}
                                ORDER BY `weight` DESC
                                LIMIT 0, 1
                              ),
                              (
                                SELECT `cost`
                                FROM `{$this->tableShipping}`
                                WHERE `type` = `t`.`id`
                                AND `country` = {$countryId}
                                AND `weight` >= {$weight}
                                ORDER BY `weight` ASC
                                LIMIT 0, 1
                              )
                            ) AS `cost`
                            FROM `{$this->tableShippingType}` `t`
                            WHERE `t`.`active` = 1
                            AND `t`.`local` = 0
                            AND `t`.`id` = {$shippingId}";
                    return $this->db->fetchOne($sql);
                }
            }
            return null;
        }

        /**
         * Get a zone by post code and post code length
         *
         * @param null $postCode
         * @param int $strLen
         * @return mixed|null
         */
        public function getZone($postCode = null, $strLen = 5) {
            if (!empty($postCode)) {
                $pc = substr($postCode, 0, $strLen);
                $sql = "SELECT *
                        FROM `{$this->tableZonesCountryCodes}`
                        WHERE `country_code` = '" . $this->db->escape($pc) . "'
                        LIMIT 0, 1";
                $result = $this->db->fetchOne($sql);
                if (empty($result) && $strLen > 1) {
                    $strLen--;
                    return $this->getZone($postCode, $strLen);
                } else {
                    return $result;
                }
            }
            return null;
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
         * Remove a post/country code by id
         *
         * @param null $id
         * @return bool|resource
         */
        public function removePostCode($id = null) {
            if (!empty($id)) {
                $sql = "DELETE FROM `{$this->tableZonesCountryCodes}`
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