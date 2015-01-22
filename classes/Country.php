<?php

/**
 * Class Country
 */
class Country extends Application
{
    /**
     * Get all countries
     *
     * @return array
     */
    public function getCountries()
    {
        $sql = "SELECT * FROM `countries`
                   ORDER BY `name` ASC";

        return $this->db->fetchAll($sql);
    }
}