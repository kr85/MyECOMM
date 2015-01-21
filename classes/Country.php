<?php

class Country extends Application
{
    public function getCountries()
    {
        $sql = "SELECT * FROM `countries`
                  ORDER BY `name` ASC";

        return $this->db->fetchAll($sql);
    }
}