<?php

/**
 * Class Catalogue
 */
class Catalogue extends Application
{
    private $tableCategories = 'categories';
    private $tableProducts = 'products';
    public $path = 'media/catalogue/';
    public static $currency = '&dollar;';


    /**
     * Get all categories
     *
     * @return array
     */
    public function getCategories()
    {
        $sql = "SELECT * FROM `{$this->tableCategories}` ORDER BY `name` ASC";

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
        $sql = "SELECT * FROM `{$this->tableCategories}`
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
        $sql = "SELECT * FROM `{$this->tableProducts}`
                  WHERE `category` ='".$this->db->escape($category['id'])."'
                  ORDER BY `date` DESC";

        return $this->db->fetchAll($sql);
    }
}