<?php

use MyECOMM\Plugin;
use MyECOMM\Catalog;
use MyECOMM\Paging;
use MyECOMM\Helper;

$objCatalog = new Catalog();
$products = $objCatalog->getAllProducts();
$productsCount = count($products);

$sections = $objCatalog->getSections();

$page = $this->objUrl->get('pg');
$page = (empty($page)) ? 1 : intval($page);
$perPageProducts = 50;

$objPagingProducts = new Paging($this->objUrl, $products, $perPageProducts);
$rowsProducts = $objPagingProducts->getRecords();
$productsOnPage = count($rowsProducts);

require_once('_header.php');

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
                        Site Map
                    </strong>
                </li>
            </ul>
        </div>
        <div class="description-wrapper">
            <div class="page-title">
                <h2>
                    Site Map:
                    <a href="" class="site-map-title" id="site-map-pro">Products</a> |
                    <a href="" class="site-map-title" id="site-map-cat">Categories</a>
                </h2>
            </div>
            <div id="products">
                <div class="toolbar">
                    <div class="pager">
                        <p class="amount">
                            <?php echo $objCatalog->getPagerAmountText(
                                $page, $productsCount, $perPageProducts, $productsOnPage
                            ); ?>
                        </p>
                        <div class="page-number">
                            <label for="page-num"><strong>Page: </strong></label>
                            <div class="input-box">
                                <input
                                    id="page-num"
                                    onfocus="this.blur()"
                                    type="text"
                                    value="<?php echo $page; ?>"
                                    readonly="readonly"
                                    />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="pages">
                            <?php if ($productsCount != 0): ?>
                                <?php echo $objPagingProducts->getPaging(); ?>
                            <?php endif; ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <ul class="pad-top-bottom-30">
                <?php
                    foreach ($rowsProducts as $product):
                        $link = $this->objUrl->href('catalog-item', [
                            'item',
                            $product['identity']
                        ]);
                        ?>
                        <li>
                            <a href="<?php echo $link; ?>">
                                <?php echo Helper::encodeHTML($product['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="toolbar">
                    <div class="pager">
                        <p class="amount">
                            <?php echo $objCatalog->getPagerAmountText(
                                $page, $productsCount, $perPageProducts, $productsOnPage
                            ); ?>
                        </p>
                        <div class="page-number">
                            <label for="page-num"><strong>Page: </strong></label>
                            <div class="input-box">
                                <input
                                    id="page-num"
                                    onfocus="this.blur()"
                                    type="text"
                                    value="<?php echo $page; ?>"
                                    readonly="readonly"
                                    />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="pages">
                            <?php if ($productsCount != 0): ?>
                                <?php echo $objPagingProducts->getPaging(); ?>
                            <?php endif; ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="categories" style="display: none;">
                <ul>
                    <li>
                        <a href="/" class="bold">New Products</a>
                    </li>
                    <?php
                        foreach ($sections as $section):
                            $link = $this->objUrl->href('catalog', [
                                'section',
                                $section['identity']
                            ]);
                    ?>
                        <li>
                            <a href="<?php echo $link; ?>" class="bold">
                                <?php echo Helper::encodeHTML($section['name']); ?>
                            </a>
                            <?php
                            $categories = $objCatalog->getCategoriesBySection($section['id']);
                            if (!empty($categories)): ?>
                                <ul>
                                    <?php
                                        foreach ($categories as $category):
                                            $link = $this->objUrl->href('catalog', [
                                                'category',
                                                $category['identity']
                                            ]);
                                    ?>
                                        <li>
                                            <a href="<?php echo $link; ?>">
                                                <?php echo Helper::encodeHTML($category['name']); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif;
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-right sidebar">
        <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
            'objUrl' => $this->objUrl,
            'objCurrency' => $this->objCurrency,
            'objCatalog' => $objCatalog,
            'listing' => 'category',
            'id' => 0,
            'productId' => 0
        ]); ?>
    </div>
</div>

<?php require_once('_footer.php'); ?>