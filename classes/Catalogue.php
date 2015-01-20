<?php

/**
 * Class Catalogue
 */
class Catalogue extends Application
{
    private $_table_categories = 'categories';
    private $_table_products = 'products';
    public $_path = 'media/catalogue/';
    public static $_currency = '&dollar;';


    /**
     * Get all categories
     *
     * @return array
     */
    public function getCategories()
    {
        $sql = "SELECT * FROM `{$this->_table_categories}` ORDER BY `name` ASC";

        return $this->db->fetchAll($sql);
    }

    /**
     * Get a category by id
     *
     * @param $id
     * @return mixed
     */
    public function getCategory($id)
    {
        $sql = "SELECT * FROM `{$this->_table_categories}`
                  WHERE `id` = '".$this->db->escape($id)."'";

        return $this->db->fetchOne($sql);
    }

    /**
     * Get all products
     *
     * @param $category
     * @return array
     */
    public function getProducts($category)
    {
        $sql = "SELECT * FROM `{$this->_table_products}`
                  WHERE `category` ='".$this->db->escape($category['id'])."'
                  ORDER BY `date` DESC";

        return $this->db->fetchAll($sql);
    }
}