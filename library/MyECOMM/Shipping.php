<?php namespace MyECOMM;

use \PDOException;

/**
 * Class Shipping
 */
class Shipping extends Application {

    /**
     * @var string Database shipping table name
     */
    protected $tableShipping = 'shipping';

    /**
     * @var string Database shipping type table name
     */
    protected $tableShippingType = 'shipping_type';

    /**
     * @var string Database zones table name
     */
    protected $tableZones = 'zones';

    /**
     * @var string Database zones country codes table name
     */
    protected $tableZonesCountryCodes = 'zones_country_codes';

    /**
     * @var Basket object instance
     */
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
                    WHERE `id` = ?";
            return $this->Db->fetchOne($sql, $id);
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
                  SELECT
                    GROUP_CONCAT(
                      `country_code`
                      ORDER BY `country_code` ASC
                      SEPARATOR ', '
                    )
                  FROM `{$this->tableZonesCountryCodes}`
                  WHERE `zone` = `z`.`id`
                ) AS `country_codes`
                FROM `{$this->tableZones}` `z`
                ORDER BY `z`.`name` ASC";
        return $this->Db->fetchAll($sql);
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
                WHERE `local` = ?
                ORDER BY `order` ASC";
        return $this->Db->fetchAll($sql, $local);
    }

    /**
     * Get a post code by id and zone id
     *
     * @param null $id
     * @param null $zoneId
     * @return mixed|null
     */
    public function getPostCode($id = null, $zoneId = null) {
        if ($this->isIdZoneNotEmpty($id, $zoneId)) {
            $sql = "SELECT *
                    FROM `{$this->tableZonesCountryCodes}`
                    WHERE `id` = ?
                    AND `zone` = ?";
            return $this->Db->fetchOne($sql, [$id, $zoneId]);
        }
        return null;
    }

    /**
     * Check if id and zone id are not empty
     *
     * @param null $id
     * @param null $zoneId
     * @return bool
     */
    private function isIdZoneNotEmpty($id = null, $zoneId = null) {
        return (!empty($id) && !empty($zoneId));
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
                    WHERE `zone` = ?
                    ORDER BY `country_code` ASC";
            return $this->Db->fetchAll($sql, $zoneId);
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
            $params['local'] = (!empty($params['local'])) ? 1 : 0;
            $last = $this->getLastType($params['local']);
            $params['order'] = (!empty($last)) ? $last['order'] + 1 : 1;
            return $this->Db->insert($this->tableShippingType, $params);
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
        return $this->Db->insert($this->tableZones, $params);
    }

    /**
     * Delete a shipping type by id
     *
     * @param null $id
     * @return bool|resource
     */
    public function removeType($id = null) {
        if (empty($id)) {
            return false;
        }

        try {
            // Begin the transaction
            $this->Db->beginTransaction();
            // Delete the shipping type and shipping rates associated with it
            $this->Db->deleteTransaction($this->tableShippingType, $id);
            $this->Db->deleteTransaction($this->tableShipping, $id, 'type');
            // Execute
            $this->Db->commit();
            return true;
        } catch (PDOException $e) {
            $this->Db->rollBack();
            return false;
        }
    }

    /**
     * Remove a zone by id
     *
     * @param null $id
     * @return bool|resource
     */
    public function removeZone($id = null) {
        return $this->Db->delete($this->tableZones, $id);
    }

    /**
     * Update a shipping type
     *
     * @param null $params
     * @param null $id
     * @return bool|resource
     */
    public function updateType($params = null, $id = null) {
        return $this->Db->update($this->tableShippingType, $params, $id);
    }

    /**
     * Update a zone
     *
     * @param null $params
     * @param null $id
     * @return bool
     */
    public function updateZone($params = null, $id = null) {
        return $this->Db->update($this->tableZones, $params, $id);
    }

    /**
     * Set a default shipping type
     *
     * @param null $id
     * @param int $local
     * @return bool|resource
     */
    public function setTypeDefault($id = null, $local = 0) {
        // If id is empty return false
        if (empty($id)) {
            return false;
        }

        try {
            // Make sure local always has a value
            $local = (empty($local)) ? 0 : 1;
            // Begin transaction
            $this->Db->beginTransaction();
            // SQL Statement
            $sql = "UPDATE `{$this->tableShippingType}`
                    SET `default` = ?
                    WHERE `local` = ?
                    AND `id` != ?";
            // Execute the transaction
            $this->Db->executeTransaction($sql, [0, $local, $id]);
            // SQL Statement
            $sql = "UPDATE `{$this->tableShippingType}`
                    SET `default` = ?
                    WHERE `local` = ?
                    AND `id` = ?";
            // Execute the transaction
            $this->Db->executeTransaction($sql, [1, $local, $id]);
            // Commit the changes
            $this->Db->commit();
            return true;
        } catch (PDOException $e) {
            $this->Db->rollBack();
            return false;
        }
    }

    /**
     * Duplicate a shipping type
     *
     * @param null $id
     * @return bool
     */
    public function duplicateType($id = null) {
        $type = $this->getType($id);
        if (empty($type)) {
            return false;
        }

        $last = $this->getLastType($type['local']);
        $order = (!empty($last)) ? $last['order'] + 1 : 1;

        try {
            // Begin the transaction
            $this->Db->beginTransaction();
            // Insert the transaction
            $this->Db->insertTransaction($this->tableShippingType, [
                'name'   => $type['name'].' copy',
                'order'  => $order,
                'local'  => $type['local'],
                'active' => 0
            ]);
            // Store the new id
            $newId = $this->Db->id;
            // Fetch all shipping rates of that shipping type
            $sql = "SELECT *
                    FROM `{$this->tableShipping}`
                    WHERE `type` = ?";
            $list = $this->Db->fetchAll($sql, $id);
            // If shipping rates exist
            if (!empty($list)) {
                // For each shipping rate insert transaction
                foreach ($list as $row) {
                    $this->Db->insertTransaction($this->tableShipping, [
                        'type'    => $newId,
                        'zone'    => $row['zone'],
                        'country' => $row['country'],
                        'weight'  => $row['weight'],
                        'cost'    => $row['cost']
                    ]);
                }
            }
            // Commit the transaction
            $this->Db->commit();
            return true;
        } catch (PDOException $e) {
            $this->Db->rollBack();
            return false;
        }
    }

    /**
     * Get a zone by id
     *
     * @param null $id
     * @return bool|mixed
     */
    public function getZoneById($id = null) {
        return $this->Db->selectOne($this->tableZones, $id);
    }

    /**
     * Get a shipping rates by type id and zone id
     *
     * @param null $typeId
     * @param null $zoneId
     * @return array|bool
     */
    public function getShippingByTypeZone($typeId = null, $zoneId = null) {
        if ($this->isTypeZoneNotEmpty($typeId, $zoneId)) {
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
                    WHERE `s`.`type` = ?
                    AND `s`.`zone` = ?
                    ORDER BY `s`.`weight` ASC";
            return $this->Db->fetchAll($sql, [$typeId, $zoneId]);
        }
        return null;
    }

    /**
     * Check if type id and zone id are empty
     *
     * @param null $typeId
     * @param null $zoneId
     * @return bool
     */
    private function isTypeZoneNotEmpty($typeId = null, $zoneId = null) {
        return (!empty($typeId) && !empty($zoneId));
    }

    /**
     * Get shipping rates by type id and country id
     *
     * @param null $typeId
     * @param null $countryId
     * @return array|bool
     */
    public function getShippingByTypeCountry($typeId = null, $countryId = null) {
        if ($this->isTypeCountryNotEmpty($typeId, $countryId)) {
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
                    WHERE `s`.`type` = ?
                    AND `s`.`country` = ?
                    ORDER BY `s`.`weight` ASC";
            return $this->Db->fetchAll($sql, [$typeId, $countryId]);
        }
        return null;
    }

    /**
     * Check if type id and country id are not empty
     *
     * @param null $typeId
     * @param null $countryId
     * @return bool
     */
    private function isTypeCountryNotEmpty($typeId = null, $countryId = null) {
        return (!empty($typeId) && !empty($countryId));
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
        if ($this->isTypeZoneWeightNotEmpty($typeId, $zoneId, $weight)) {
            $sql = "SELECT *
                    FROM `{$this->tableShipping}`
                    WHERE `type` = ?
                    AND `zone` = ?
                    AND `weight` = ?";
            $result = $this->Db->fetchOne($sql, [$typeId, $zoneId, $weight]);
            return (!empty($result)) ? true : false;
        }
        return true;
    }

    /**
     * Check if type id, zone id and weight are not empty
     *
     * @param null $typeId
     * @param null $zoneId
     * @param null $weight
     * @return bool
     */
    private function isTypeZoneWeightNotEmpty(
        $typeId = null, $zoneId = null, $weight = null
    ) {
        return (!empty($typeId) && !empty($zoneId) && !empty($weight));
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
        if ($this->isTypeCountryWeightNotEmpty($typeId, $countryId, $weight)) {
            $sql = "SELECT *
                    FROM `{$this->tableShipping}`
                    WHERE `type` = ?
                    AND `country` = ?
                    AND `weight` = ?";
            $result = $this->Db->fetchOne($sql, [$typeId, $countryId, $weight]);
            return (!empty($result)) ? true : false;
        }
        return true;
    }

    /**
     * Check if type id, country id and weight are not empty
     *
     * @param null $typeId
     * @param null $countryId
     * @param null $weight
     * @return bool
     */
    private function isTypeCountryWeightNotEmpty(
        $typeId = null, $countryId = null, $weight = null
    ) {
        return (!empty($typeId) && !empty($countryId) && !empty($weight));
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
                    WHERE `country_code` = ?";
            $result = $this->Db->fetchOne($sql, $postCode);
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
        return $this->Db->insert($this->tableShipping, $params);
    }

    /**
     * Add a new post/country code
     *
     * @param null $params
     * @return bool
     */
    public function addPostCode($params = null) {
        return $this->Db->insert($this->tableZonesCountryCodes, $params);
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
        if ($this->isIdTypeZoneNotEmpty($id, $typeId, $zoneId)) {
            $sql = "SELECT *
                    FROM `{$this->tableShipping}`
                    WHERE `id` = ?
                    AND `type` = ?
                    AND `zone` = ?";
            return $this->Db->fetchOne($sql, [$id, $typeId, $zoneId]);
        }
        return null;
    }

    /**
     * Check if id, type id and zone id are not empty
     *
     * @param null $id
     * @param null $typeId
     * @param null $zoneId
     * @return bool
     */
    private function isIdTypeZoneNotEmpty(
        $id = null, $typeId = null, $zoneId = null
    ) {
        return (!empty($id) && !empty($typeId) && !empty($zoneId));
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
        if ($this->isIdTypeCountryNotEmpty($id, $typeId, $countryId)) {
            $sql = "SELECT *
                    FROM `{$this->tableShipping}`
                    WHERE `id` = ?
                    AND `type` = ?
                    AND `country` = ?";
            return $this->Db->fetchOne($sql, [$id, $typeId, $countryId]);
        }
        return null;
    }

    /**
     * Check if id, type id and country id are not empty
     *
     * @param null $id
     * @param null $typeId
     * @param null $countryId
     * @return bool
     */
    private function isIdTypeCountryNotEmpty(
        $id = null, $typeId = null, $countryId = null
    ) {
        return (!empty($id) && !empty($typeId) && !empty($countryId));
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
            // If shipping is local...
            if ($this->isShippingLocal($user)) {
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
                          ? > (
                            SELECT MAX(`weight`)
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `zone` = ?
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `zone` = ?
                            ORDER BY `weight` DESC
                            LIMIT 0, 1
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `zone` = ?
                            AND `weight` >= ?
                            ORDER BY `weight` ASC
                            LIMIT 0, 1
                          )
                        ) AS `cost`
                        FROM `{$this->tableShippingType}` `t`
                        WHERE `t`.`active` = ?
                        AND `t`.`local` = ?
                        ORDER BY `t`.`order` ASC";
                return $this->Db->fetchAll($sql, [
                    $weight, $zoneId, $zoneId, $zoneId, $weight, 1 , 1
                ]);
            } else {
                $countryId = ($user['same_address'] == 1) ?
                    $user['country'] :
                    $user['shipping_country'];

                $sql = "SELECT `t`.*,
                        IF (
                          ? > (
                            SELECT MAX(`weight`)
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `country` = ?
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `country` = ?
                            ORDER BY `weight` DESC
                            LIMIT 0, 1
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `country` = ?
                            AND `weight` >= ?
                            ORDER BY `weight` ASC
                            LIMIT 0, 1
                          )
                        ) AS `cost`
                        FROM `{$this->tableShippingType}` `t`
                        WHERE `t`.`active` = ?
                        AND `t`.`local` = ?
                        ORDER BY `t`.`order` ASC";
                return $this->Db->fetchAll($sql, [
                    $weight, $countryId, $countryId, $countryId, $weight, 1, 0
                ]);
            }
        }
        return null;
    }

    /**
     * Check if shipping is local
     *
     * @param null $user
     * @return bool
     */
    private function isShippingLocal($user = null) {
        return (
            ($user['same_address'] == 1 && $user['country'] == COUNTRY_LOCAL) ||
            ($user['same_address'] == 0 && $user['shipping_country'] == COUNTRY_LOCAL)
        );
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
                        WHERE `local` = ?
                        AND `active` = ?
                        AND `default` = ?";
                return $this->Db->fetchOne($sql, [1, 1, 1]);
            } else {
                $sql = "SELECT *
                        FROM `{$this->tableShippingType}`
                        WHERE `local` = ?
                        AND `active` = ?
                        AND `default` = ?";
                return $this->Db->fetchOne($sql, [0, 1, 1]);
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

            if ($this->isShippingLocal($user)) {
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
                          ? > (
                            SELECT MAX(`weight`)
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `zone` = ?
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `zone` = ?
                            ORDER BY `weight` DESC
                            LIMIT 0, 1
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `zone` = ?
                            AND `weight` >= ?
                            ORDER BY `weight` ASC
                            LIMIT 0, 1
                          )
                        ) AS `cost`
                        FROM `{$this->tableShippingType}` `t`
                        WHERE `t`.`active` = ?
                        AND `t`.`local` = ?
                        AND `t`.`id` = ?";
                return $this->Db->fetchOne($sql, [
                    $weight, $zoneId, $zoneId, $zoneId, $weight, 1, 1, $shippingId
                ]);
            } else {
                $countryId = ($user['same_address'] == 1) ?
                    $user['country'] :
                    $user['shipping_country'];

                $sql = "SELECT `t`.*,
                        IF (
                          ? > (
                            SELECT MAX(`weight`)
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `country` = ?
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `country` = ?
                            ORDER BY `weight` DESC
                            LIMIT 0, 1
                          ),
                          (
                            SELECT `cost`
                            FROM `{$this->tableShipping}`
                            WHERE `type` = `t`.`id`
                            AND `country` = ?
                            AND `weight` >= ?
                            ORDER BY `weight` ASC
                            LIMIT 0, 1
                          )
                        ) AS `cost`
                        FROM `{$this->tableShippingType}` `t`
                        WHERE `t`.`active` = ?
                        AND `t`.`local` = ?
                        AND `t`.`id` = ?";
                return $this->Db->fetchOne($sql, [
                    $weight, $countryId, $countryId,
                    $countryId, $weight, 1, 0, $shippingId
                ]);
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
                    WHERE `country_code` = ?
                    LIMIT 0, 1";
            $result = $this->Db->fetchOne($sql, $pc);
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
        return $this->delete($id);
    }

    /**
     * Remove a post/country code by id
     *
     * @param null $id
     * @return bool|resource
     */
    public function removePostCode($id = null) {
        return $this->Db->delete($this->tableZonesCountryCodes, $id);
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
                WHERE `local` = ?
                ORDER BY `order` DESC
                LIMIT 0, 1";
        return $this->Db->fetchOne($sql, $local);
    }
}