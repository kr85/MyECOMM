<?php

use MyECOMM\Catalog;
use MyECOMM\Paging;
use MyECOMM\Helper;
use MyECOMM\Basket;
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
        $rows = $objCatalog->getProductsByCategory($category['id']);
        // Instantiate paging class
        $objPaging = new Paging($this->objUrl, $rows, 3);
        $rows = $objPaging->getRecords();

        require_once("_header.php");
        ?>
<section>
    <div class="container">
        <div class="main">

        </div>
    </div>
</section>
        <h1>Catalog :: <?php echo $category['name']; ?></h1>
        <?php
        if (!empty($rows)):
            foreach ($rows as $row): ?>
            <div class="catalog_wrapper">
                <div class="catalog_wrapper_left">
                    <?php
                        $image = !empty($row['image']) ?
                            $row['image'] :
                            'unavailable.png';

                        $width = Helper::getImageSize(
                            CATALOG_PATH.DS.$image,
                            0
                        );
                        $width = ($width > 120) ? 120 : $width;

                        $link = $this->objUrl->href('catalog-item', [
                            'category',
                            $category['identity'],
                            'item',
                            $row['identity']
                        ]);
                    ?>
                    <a href="<?php echo $link; ?>">
                        <img
                            src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                            alt="<?php echo Helper::encodeHTML(
                                $row['name'],
                                1
                            ); ?>" width="<?php echo $width; ?>"/> </a>
                </div>
                <div class="catalog_wrapper_right">
                    <h4>
                        <a href="<?php echo $link; ?>">
                            <?php echo Helper::encodeHTML(
                                $row['name'],
                                1
                            ); ?>
                        </a>
                    </h4>
                    <h4>Price:
                        <?php echo $this->objCurrency->display(
                            number_format($row['price'], 2)
                        ); ?>
                    </h4>

                    <p>
                        <?php echo Helper::shortenString(
                            Helper::encodeHTML($row['description'])
                        );
                        ?>
                    </p>

                    <p>
                        <?php echo Basket::activeButton($row['id']); ?>
                    </p>
                </div>
            </div>
            <?php endforeach;
            // Display pagination links
            echo $objPaging->getPaging();
        else: ?>
            <p>There are no products in this category.</p>
        <?php endif;

        require_once("_footer.php");
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
                        'objUrl' => $this->objUrl
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