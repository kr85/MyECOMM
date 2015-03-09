<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Plugin;

$category = $this->objUrl->get('category');
$section = $this->objUrl->get('section');
$page = $this->objUrl->get('pg');

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
        $products = $objCatalog->getProductsByCategory($category['id']);
        $section = $objCatalog->getSection($category['section']);
        $page = (empty($page)) ? 1 : intval($page);
        $perPage = 5;
        require_once("_header.php");
        ?>
        <section>
            <div class="container col-separator">
                <div class="main">
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

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </section>
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
        // Get all products of a category
        $products = $objCatalog->getProductsBySection($section['id']);
        $page = (empty($page)) ? 1 : intval($page);
        $perPage = 5;
        require_once("_header.php");
        ?>
<section>
    <div class="container col-separator">
        <div class="main">
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

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</section>
        <?php require_once("_footer.php");
    endif;
endif;
?>