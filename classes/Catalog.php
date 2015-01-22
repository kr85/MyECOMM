<?php

/**
 * Class Catalog
 */
class Catalog extends Application
{
    // The name of the categories table
    private $tableCategories = 'categories';

    // The name of the products table
    private $tableProducts = 'products';

    // The path to the catalog images
    public $path = 'media/catalog/';

    // Country's official currency
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

    /**
     * Get a product by id
     *
     * @param $id
     * @return mixed
     */
    public function getProduct($id)
    {
        $sql = "SELECT * FROM `{$this->tableProducts}`
                  WHERE `id` ='".$this->db->escape($id)."'";

        return $this->db->fetchOne($sql);
    }
}