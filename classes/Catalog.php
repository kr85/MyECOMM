<?php

    /**
     * Class Catalog
     */
    class Catalog extends Application {

        // The name of the categories table
        private $tableCategories = 'categories';

        // The name of the products table
        private $tableProducts = 'products';

        // The path to the catalog images
        public $path = 'media/catalog/';

        // Country's official currency
        public static $currency = '&dollar;';

        // Record id
        public $id;


        /**
         * Get all categories
         *
         * @return array
         */
        public function getCategories() {

            $sql = "SELECT * FROM `{$this->tableCategories}`
                    ORDER BY `name` ASC";

            return $this->db->fetchAll($sql);
        }

        /**
         * Get a category by id
         *
         * @param $id
         * @return mixed
         */
        public function getCategory($id) {

            $sql = "SELECT * FROM `{$this->tableCategories}`
                    WHERE `id` = '" . $this->db->escape($id) . "'";

            return $this->db->fetchOne($sql);
        }

        /**
         * Add a new category
         *
         * @param null $name
         * @return bool|resource
         */
        public function addCategory($name = null) {

            if (!empty($name)) {
                $sql = "INSERT INTO `$this->tableCategories`
                        (`name`) VALUES ('" . $this->db->escape($name) . "')";

                return $this->db->query($sql);
            }

            return false;
        }

        /**
         * Update an existing category
         *
         * @param null $name
         * @param null $id
         * @return bool|resource
         */
        public function updateCategory($name = null, $id = null) {

            if (!empty($name) && !empty($id)) {
                $sql = "UPDATE `{$this->tableCategories}`
                        SET `name` = '" . $this->db->escape($name) . "'
                        WHERE `id` = '" . $this->db->escape($id) ."'";

                return $this->db->query($sql);
            }

            return false;
        }

        /**
         * Delete a category by id
         *
         * @param null $id
         * @return bool|resource
         */
        public function removeCategory($id = null) {

            if (!empty($id)) {
                $sql = "DELETE FROM `{$this->tableCategories}`
                        WHERE `id` = '" . $this->db->escape($id) ."'";

                return $this->db->query($sql);
            }

            return false;
        }

        /**
         * Check if a category already exist
         *
         * @param null $name
         * @param null $id
         * @return bool|mixed
         */
        public function duplicateCategory($name = null, $id = null) {

            if (!empty($name)) {
                $sql = "SELECT * FROM `{$this->tableCategories}`
                        WHERE `name` = '" . $this->db->escape($name) . "'";
                $sql .= !empty($id) ?
                    " AND `id` = '" . $this->db->escape($id) . "'" :
                    null;

                return $this->db->fetchOne($sql);
            }

            return false;
        }

        /**
         * Get all products
         *
         * @param $category
         * @return array
         */
        public function getProducts($category) {

            $sql = "SELECT * FROM `{$this->tableProducts}`
                    WHERE `category` ='" . $this->db->escape($category['id']) . "'
                    ORDER BY `date` DESC";

            return $this->db->fetchAll($sql);
        }

        /**
         * Get a product by id
         *
         * @param $id
         * @return mixed
         */
        public function getProduct($id) {

            $sql = "SELECT * FROM `{$this->tableProducts}`
                    WHERE `id` ='" . $this->db->escape($id) . "'";

            return $this->db->fetchOne($sql);
        }

        /**
         * Get all products with a search criteria if provided
         *
         * @param null $search
         * @return array
         */
        public function getAllProducts($search = null) {

            $sql = "SELECT * FROM `{$this->tableProducts}`";

            if (!empty($search)) {
                $search = $this->db->escape($search);
                $sql .= " WHERE `name` LIKE '%{$search}%' || `id` = '{$search}'";
            }
            $sql .= " ORDER BY `date` DESC";

            return $this->db->fetchAll($sql);
        }

        /**
         * Add a new product
         *
         * @param null $data
         * @return bool
         */
        public function addProduct($data = null) {

            if (!empty($data)) {
                $data['date'] = Helper::setDate();
                $this->db->prepareInsert($data);
                $out = $this->db->insert($this->tableProducts);
                $this->id = $this->db->id;

                return $out;
            }

            return false;
        }

        /**
         * Update an existing product
         *
         * @param null $data
         * @param null $id
         * @return resource
         */
        public function updateProduct($data = null, $id = null) {

            if (!empty($data) && !empty($id)) {
                $this->db->prepareUpdate($data);
                return $this->db->update($this->tableProducts, $id);
            }

            return false;
        }

        /**
         * Delete an existing product by id
         *
         * @param null $id
         * @return bool|resource
         */
        public function removeProduct($id = null) {

            if (!empty($id)) {
                $product = $this->getProduct($id);

                if (!empty($product)) {
                    if (is_file(CATALOG_PATH . DS . $product['image'])) {
                        unlink(CATALOG_PATH . DS . $product['image']);
                    }

                    $sql = "DELETE FROM `{$this->tableProducts}`
                            WHERE `id` = '" . $this->db->escape($id) . "'";

                    return $this->db->query($sql);
                }

                return false;
            }

            return false;
        }
    }