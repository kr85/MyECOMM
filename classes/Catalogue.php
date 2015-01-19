<?php

/**
 * Class Catalogue
 */
class Catalogue extends Application
{
    private $_table = 'categories';

    /**
     * Get all categories
     *
     * @return array
     */
    public function getCategories()
    {
        $sql = "SELECT * FROM `{$this->_table}` ORDER BY `name` ASC";

        return $this->db->fetchAll($sql);
    }
}