<?php namespace MyECOMM;

/**
 * Class Country
 */
class Country extends Application {

    /**
     * @var string The Database country table name
     */
    protected $table = 'countries';

    /**
     * @var string TThe Database states table name
     */
    protected $tableStates = 'states';

    /**
     * Get all countries
     *
     * @return array
     */
    public function getCountries() {
        $sql = "SELECT *
                FROM `{$this->table}`
                WHERE `include` = ?
                ORDER BY `name` ASC";
        return $this->Db->fetchAll($sql, 1);
    }

    /**
     * Get all states of a country
     *
     * @param null $countryId
     * @return mixed|null
     */
    public function getStates($countryId = null) {
        if (!empty($countryId)) {
            $sql = "SELECT *
                    FROM `{$this->tableStates}`
                    WHERE `country` = ?
                    ORDER BY `name` ASC";
            return $this->Db->fetchAll($sql, $countryId);
        }
        return null;
    }

    /**
     * Get a list of all countries except the local ones
     *
     * @return array
     */
    public function getAllExceptLocal() {
        $sql = "SELECT *
                FROM `{$this->table}`
                WHERE `id` != ?
                ORDER BY `name` ASC";
        return $this->Db->fetchAll($sql, COUNTRY_LOCAL);
    }

    /**
     * Get a list of all countries
     *
     * @return array
     */
    public function getAll() {
        $sql = "SELECT *
                FROM `{$this->table}`
                ORDER BY `name` ASC";
        return $this->Db->fetchAll($sql);
    }

    /**
     * Get country by id
     *
     * @param null $id
     * @return mixed
     */
    public function getCountry($id = null) {
        if (!empty($id)) {
            $sql = "SELECT *
                    FROM `{$this->table}`
                    WHERE `id` = ?
                    AND `include` = ?";
            return $this->Db->fetchOne($sql, [$id, 1]);
        }
        return null;
    }
}