<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Plugin;

$category = $this->objUrl->get('category');
$section = $this->objUrl->get('section');
$page = $this->objUrl->get('pg');
$price = $this->objUrl->get('price');

if (isset($_POST['search'])) {
    if (!empty($_POST['search'])) {
        $url = $this->objUrl->getCurrent('search').'/search/'.urlencode(
                stripslashes($_POST['search'])
            );
    } else {
        $url = $this->objUrl->getCurrent('search');
    }
    Helper::redirect($url);
} else {
    $search = stripslashes(urlencode($this->objUrl->get('search')));

}

if (empty($category) && empty($section)):
    require_once("error.php");
elseif (empty($section) && !empty($category)):
    // Instantiate catalog class
    $objCatalog = new Catalog();
    $category = $objCatalog->getCategoryByIdentity($category);

    if (empty($category)):
        require_once("error.php");
    else:
        $this->metaTitle = $category['meta_title'];
        $this->metaDescription = $category['meta_description'];
        // Get all products of a category
        if (!empty($price)) {
            $products = $objCatalog->getProductsByPrice($category['id'], $price, 'category');
        } else {
            $products = $objCatalog->getProductsByCategory($category['id']);
        }
        $section = $objCatalog->getSection($category['section']);
        $page = (empty($page)) ? 1 : intval($page);
        $perPage = 3;
        require_once("_header.php");
        ?>
        <div class="main pad-bottom">
            <div class="col-main">
                <div class="breadcrumbs">
                    <ul>
                        <li class="home">
                            <a href="/" title="Go to Home Page">Home</a>
                            <span>&nbsp;</span>
                        </li>
                        <li class="section">
                            <a
                                href="<?php echo $this->objUrl->href('catalog', [
                                    'section',
                                    $section['identity']
                                ]); ?>"
                                title="Go to <?php
                                    echo Helper::encodeHTML($section['name']);
                            ?> Section">
                                <?php echo Helper::encodeHTML($section['name']); ?>
                            </a>
                            <span>&nbsp;</span>
                        </li>
                        <li>
                            <strong>
                                <?php echo Helper::encodeHTML($category['name']); ?>
                            </strong>
                        </li>
                    </ul>
                </div>
                <div class="page-title category-title">
                    <h1>
                        <?php echo Helper::encodeHTML($category['name']); ?>
                    </h1>
                </div>
                <div class="category-products" id="category-products">
                    <?php echo Plugin::get('front'.DS.'category_products', [
                        'products' => $products,
                        'page' => $page,
                        'objCurrency' => $this->objCurrency,
                        'objCatalog' => $objCatalog,
                        'perPage' => $perPage,
                        'sectionId' => $category['id'],
                        'objUrl' => $this->objUrl,
                        'listing' => 'category'
                    ]); ?>
                </div>
            </div>
            <div class="col-right sidebar">
                <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
                    'objUrl' => $this->objUrl,
                    'objCurrency' => $this->objCurrency,
                    'objCatalog' => $objCatalog,
                    'listing' => 'category',
                    'id' => $category['id']
                ]); ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php require_once("_footer.php");
    endif;
elseif (empty($category) && !empty($section)):
    // Instantiate catalog class
    $objCatalog = new Catalog();
    $section = $objCatalog->getSectionByIdentity($section);

    if (empty($section)):
        require_once("error.php");
    else:
        $this->metaTitle = $section['meta_title'];
        $this->metaDescription = $section['meta_description'];
        // Get all products of a section
        if (!empty($price)) {
            $products = $objCatalog->getProductsByPrice($section['id'], $price, 'section');
        } else {
            $products = $objCatalog->getProductsBySection($section['id']);
        }
        $page = (empty($page)) ? 1 : intval($page);
        $perPage = 3;
        require_once("_header.php");
        ?>
        <div class="main pad-bottom">
            <div class="col-main">
                <div class="breadcrumbs">
                    <ul>
                        <li class="home">
                            <a href="/" title="Go to Home Page">Home</a>
                            <span>&nbsp;</span>
                        </li>
                        <li>
                            <strong>
                                <?php echo Helper::encodeHTML($section['name']); ?>
                            </strong>
                        </li>
                    </ul>
                </div>
                <div class="page-title category-title">
                    <h1>
                        <?php echo Helper::encodeHTML($section['name']); ?>
                    </h1>
                </div>
                <div class="category-products" id="category-products">
                    <?php echo Plugin::get('front'.DS.'category_products', [
                        'products' => $products,
                        'page' => $page,
                        'objCurrency' => $this->objCurrency,
                        'objCatalog' => $objCatalog,
                        'perPage' => $perPage,
                        'sectionId' => $section['id'],
                        'objUrl' => $this->objUrl,
                        'listing' => 'section'
                    ]); ?>
                </div>
            </div>
            <div class="col-right sidebar">
                <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
                    'objUrl' => $this->objUrl,
                    'objCurrency' => $this->objCurrency,
                    'objCatalog' => $objCatalog,
                    'listing' => 'section',
                    'id' => $section['id']
                ]); ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php require_once("_footer.php");
    endif;
endif;
?>