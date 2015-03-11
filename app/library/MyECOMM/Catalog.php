<?php namespace MyECOMM;

/**
 * Class Catalog
 */
class Catalog extends Application {

    /**
     * @var string The name of the categories table
     */
    protected $tableCategories = 'categories';

    /**
     * @var string The name of the products table
     */
    protected $tableProducts = 'products';

    /**
     * @var string The name of the sections table
     */
    protected $tableSections = 'sections';

    /**
     * @var Record id
     */
    public $id;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get a category by identity
     *
     * @param null $identity
     * @return bool|mixed
     */
    public function getCategoryByIdentity($identity = null) {
        if (!empty($identity)) {
            $sql = "SELECT *
                    FROM `{$this->tableCategories}`
                    WHERE `identity` = ?";
            return $this->Db->fetchOne($sql, $identity);
        }
        return null;
    }

    /**
     * Get categories by section
     *
     * @param null $section
     * @return bool|mixed
     */
    public function getCategoriesBySection($section = null) {
        if (!empty($section)) {
            $sql = "SELECT *
                    FROM `{$this->tableCategories}`
                    WHERE `section` = ?";
            return $this->Db->fetchAll($sql, $section);
        }
        return null;
    }

    /**
     * Get a section by identity
     *
     * @param null $identity
     * @return bool|mixed
     */
    public function getSectionByIdentity($identity = null) {
        if (!empty($identity)) {
            $sql = "SELECT *
                    FROM `{$this->tableSections}`
                    WHERE `identity` = ?";
            return $this->Db->fetchOne($sql, $identity);
        }
        return null;
    }

    /**
     * Get all categories
     *
     * @return array
     */
    public function getCategories() {
        $sql = "SELECT *
                FROM `{$this->tableCategories}`
                WHERE `id` != ?
                ORDER BY `name` ASC";
        return $this->Db->fetchAll($sql, 0);
    }

    /**
     * Get all sections
     *
     * @return array
     */
    public function getSections() {
        $sql = "SELECT *
                FROM `{$this->tableSections}`
                WHERE `id` != ?
                ORDER BY `name` ASC";
        return $this->Db->fetchAll($sql, 0);
    }

    /**
     * Get a category by id
     *
     * @param null $id
     * @return bool|mixed
     */
    public function getCategory($id = null) {
        if (!empty($id)) {
            $sql = "SELECT `c`.*,
                    (
                        SELECT COUNT(`id`)
                        FROM `{$this->tableProducts}`
                        WHERE `category` = `c`.`id`
                    ) AS `product_count`
                    FROM `{$this->tableCategories}` `c`
                    WHERE `c`.`id` = ?";
            return $this->Db->fetchOne($sql, $id);
        }
        return null;
    }

    /**
     * Get a section by id
     *
     * @param null $id
     * @return bool|mixed
     */
    public function getSection($id = null) {
        if (!empty($id)) {
            $sql = "SELECT `s`.*,
                    (
                        SELECT COUNT(`id`)
                        FROM `{$this->tableCategories}`
                        WHERE `section` = `s`.`id`
                    ) AS `categories_count`
                    FROM `{$this->tableSections}` `s`
                    WHERE `s`.`id` = ?";
            return $this->Db->fetchOne($sql, $id);
        }
        return null;
    }

    /**
     * Add a new category
     *
     * @param null $array
     * @return bool|resource
     */
    public function addCategory($array = null) {
        if (!Helper::isArrayEmpty($array)) {
            return $this->Db->insert($this->tableCategories, [
                'name' => $array['name'],
                'identity' => $array['identity'],
                'meta_title' => $array['meta_title'],
                'meta_description' => $array['meta_description']
            ]);
        }
        return false;
    }

    /**
     * Add a new category
     *
     * @param null $array
     * @return bool|resource
     */
    public function addSection($array = null) {
        if (!Helper::isArrayEmpty($array)) {
            return $this->Db->insert($this->tableSections, [
                'name' => $array['name'],
                'identity' => $array['identity'],
                'meta_title' => $array['meta_title'],
                'meta_description' => $array['meta_description']
            ]);
        }
        return false;
    }

    /**
     * Update an existing category
     *
     * @param null $array
     * @param null $id
     * @return bool|resource
     */
    public function updateCategory($array = null, $id = null) {
        if (!Helper::isArrayEmpty($array) && !empty($id)) {
            return $this->Db->update($this->tableCategories, [
                'name' => $array['name'],
                'identity' => $array['identity'],
                'meta_title' => $array['meta_title'],
                'meta_description' => $array['meta_description']
            ], $id);
        }
        return false;
    }

    /**
     * Update an existing section
     *
     * @param null $array
     * @param null $id
     * @return bool|resource
     */
    public function updateSection($array = null, $id = null) {
        if (!Helper::isArrayEmpty($array) && !empty($id)) {
            return $this->Db->update($this->tableSections, [
                'name' => $array['name'],
                'identity' => $array['identity'],
                'meta_title' => $array['meta_title'],
                'meta_description' => $array['meta_description']
            ], $id);
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
        return $this->Db->delete($this->tableCategories, $id);
    }

    /**
     * Delete a section by id
     *
     * @param null $id
     * @return bool|resource
     */
    public function removeSection($id = null) {
        return $this->Db->delete($this->tableSections, $id);
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
            $params = [];
            $params[] = $name;
            $sql = "SELECT *
                    FROM `{$this->tableCategories}`
                    WHERE `name` = ?";
            if (!empty($id)) {
                $params[] = $id;
                $sql .= " AND `id` = ?";
            }
            return $this->Db->fetchOne($sql, $params);
        }
        return false;
    }
    /**
     * Check if a section already exist
     *
     * @param null $name
     * @param null $id
     * @return bool|mixed
     */
    public function duplicateSection($name = null, $id = null) {
        if (!empty($name)) {
            $params = [];
            $params[] = $name;
            $sql = "SELECT *
                    FROM `{$this->tableSections}`
                    WHERE `name` = ?";
            if (!empty($id)) {
                $params[] = $id;
                $sql .= " AND `id` = ?";
            }
            return $this->Db->fetchOne($sql, $params);
        }
        return false;
    }

    /**
     * Check if a category already exists by identity and id
     *
     * @param null $identity
     * @param null $id
     * @return bool
     */
    public function isDuplicateCategory($identity = null, $id = null) {
        if (!empty($identity)) {
            $params = [];
            $params[] = $identity;
            $sql = "SELECT *
                    FROM `{$this->tableCategories}`
                    WHERE `identity` = ?";
            if (!empty($id)) {
                $params[] = $id;
                $sql .= " AND `id` = ?";
            }
            $result = $this->Db->fetchAll($sql, $params);
            return (!empty($result)) ? true : false;
        }
        return false;
    }

    /**
     * Check if a section already exists by identity and id
     *
     * @param null $identity
     * @param null $id
     * @return bool
     */
    public function isDuplicateSection($identity = null, $id = null) {
        if (!empty($identity)) {
            $params = [];
            $params[] = $identity;
            $sql = "SELECT *
                    FROM `{$this->tableSections}`
                    WHERE `identity` = ?";
            if (!empty($id)) {
                $params[] = $id;
                $sql .= " AND `id` = ?";
            }
            $result = $this->Db->fetchAll($sql, $params);
            return (!empty($result)) ? true : false;
        }
        return false;
    }

    /**
     * Get a product by identity
     *
     * @param null $identity
     * @return bool|mixed
     */
    public function getProductByIdentity($identity = null) {
        if (!empty($identity)) {
            $sql = "SELECT *
                    FROM `{$this->tableProducts}`
                    WHERE `identity` = ?";
            return $this->Db->fetchOne($sql, $identity);
        }
        return null;
    }

    /**
     * Get all products of a category
     *
     * @param $category
     * @return array
     */
    public function getProductsByCategory($category = null) {
        if (!empty($category)) {
            $sql = "SELECT *
                FROM `{$this->tableProducts}`
                WHERE `category` = ?
                ORDER BY `date` DESC";
            return $this->Db->fetchAll($sql, $category);
        }
        return null;
    }

    /**
     * Get all products of a section
     *
     * @param null $section
     * @return mixed|null
     */
    public function getProductsBySection($section = null) {
        if (!empty($section)) {
            $sql = "SELECT *
                FROM `{$this->tableProducts}`
                WHERE `section` = ?
                ORDER BY `date` DESC";
            return $this->Db->fetchAll($sql, $section);
        }
        return null;
    }


    /**
     * Get a product by id
     *
     * @param $id
     * @return mixed
     */
    public function getProduct($id = null) {
        return $this->Db->selectOne($this->tableProducts, $id);
    }

    /**
     * Get a set of the latest products
     *
     * @return mixed
     */
    public function getLatestProducts() {
        $sql = "SELECT *
                FROM `{$this->tableProducts}`
                ORDER BY `id` DESC
                LIMIT 18";
        return $this->Db->fetchAll($sql);
    }

    /**
     * Check if a product already exists by identity and id
     *
     * @param null $identity
     * @param null $id
     * @return bool
     */
    public function isDuplicateProduct($identity = null, $id = null) {
        if (!empty($identity)) {
            $params = [];
            $params[] = $identity;
            $sql = "SELECT *
                    FROM `{$this->tableProducts}`
                    WHERE `identity` = ?";
            if (!empty($id)) {
                $params[] = $id;
                $sql .= " AND `id` = ?";
            }
            $result = $this->Db->fetchAll($sql, $params);
            return (!empty($result)) ? true : false;
        }
        return false;
    }

    /**
     * Get all products with a search criteria if provided
     *
     * @param null $search
     * @return array
     */
    public function getAllProducts($search = null) {
        $params = [];
        $sql = "SELECT *
                FROM `{$this->tableProducts}`";
        if (!empty($search)) {
            $sql .= " WHERE `name` LIKE ? || `id` = ?";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        $sql .= " ORDER BY `date` DESC";
        return $this->Db->fetchAll($sql, $params);
    }

    /**
     * Add a new product
     *
     * @param null $data
     * @return bool
     */
    public function addProduct($data = null) {
        if ($this->Db->insert($this->tableProducts, $data)) {
            $this->id = $this->Db->id;
            return true;
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
        return $this->Db->update($this->tableProducts, $data, $id);
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
                if (is_file(CATALOG_PATH.DS.$product['image'])) {
                    unlink(CATALOG_PATH.DS.$product['image']);
                }
                return $this->Db->delete($this->tableProducts, $id);
            }
            return false;
        }
        return false;
    }

    /**
     * Get a list of the products sorted by price
     *
     * @param null $id
     * @param null $listing
     * @return array|null
     */
    public function getProductPriceRanges($id = null, $listing = null) {
        if (!empty($id)) {
            if ($listing == 'section') {
                $products = $this->getProductsBySection($id);
            } elseif ($listing == 'category') {
                $products = $this->getProductsByCategory($id);
            } else {
                return null;
            }
            $priceList = [];
            foreach ($products as $product) {
                if (floatval($product['price']) < 10) {
                    $priceList[10][] = $product;
                } elseif (floatval($product['price']) < 20) {
                    $priceList[20][] = $product;
                } elseif (floatval($product['price']) < 30) {
                    $priceList[30][] = $product;
                } elseif (floatval($product['price']) < 40) {
                    $priceList[40][] = $product;
                } elseif (floatval($product['price']) < 50) {
                    $priceList[50][] = $product;
                } elseif (floatval($product['price']) < 60) {
                    $priceList[60][] = $product;
                } elseif (floatval($product['price']) < 70) {
                    $priceList[70][] = $product;
                } elseif (floatval($product['price']) < 80) {
                    $priceList[80][] = $product;
                } elseif (floatval($product['price']) < 90) {
                    $priceList[90][] = $product;
                } else {
                    $priceList['more'][] = $product;
                }
            }
            return $priceList;
        }
        return null;
    }

    /**
     * Get all products of a price range
     *
     * @param $id
     * @param $price
     * @param $listing
     * @return mixed
     */
    public function getProductsByPrice($id, $price, $listing) {
        $products = $this->getProductPriceRanges($id, $listing);
        return $products[$price];
    }

    /**
     * Get a list of html links for price ranges
     *
     * @param $id
     * @param $listing
     * @return array
     */
    public function getProductsByPriceLinks($id, $listing) {
        $products = $this->getProductPriceRanges($id, $listing);
        if ($listing == 'section') {
            $row = $this->getSection($id);
        } else {
            $row = $this->getCategory($id);
        }

        $objUrl = new Url();
        $objCurrency = new Currency();

        $out = [];
        foreach ($products as $key => $array) {
            $link = $objUrl->href('catalog', [$listing, $row['identity'], 'price', $key]);
            if ($key != 'more') {
                $fromPrice = floatval($key) - 10;
                $fromPrice = $fromPrice.'.00';
                $toPrice = floatval($key).'.00';
                $name = $objCurrency->display($fromPrice).' - '.$objCurrency->display($toPrice);
            } else {
                $name = 'More';
            }

            $out[$key]  = '<li>';
            $out[$key] .= '<a href="';
            $out[$key] .= $link;
            $out[$key] .= '" title="';
            $out[$key] .= $name;
            $out[$key] .= '">';
            $out[$key] .= Helper::encodeHTML($name).' ('.count($array).')';
            $out[$key] .= '</a>';
            $out[$key] .= '</li>';
        }
        sort($out);
        return $out;
    }
}