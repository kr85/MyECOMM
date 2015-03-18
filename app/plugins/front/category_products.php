<?php

use MyECOMM\Helper;
use MyECOMM\Basket;
use MyECOMM\Paging;

$objUrl = $data['objUrl'];
$productsPerPage = $data['perPage'];
$products = $data['products'];
$productsCount = count($products);
$page = $data['page'];
$listing = $data['listing'];

$objPaging = new Paging($objUrl, $products, $productsPerPage);
$rows = $objPaging->getRecords();
$productsOnPage = count($rows);

?>
<div class="toolbar">
    <div class="pager">
        <p class="amount">
            <?php echo $data['objCatalog']->getPagerAmountText(
                $page, $productsCount, $productsPerPage, $productsOnPage
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
            <?php echo $objPaging->getPaging(); ?>
            <?php endif; ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php if (!empty($rows)): ?>
    <ol class="products-list">
        <?php foreach ($rows as $product): ?>
            <li class="item">
            <?php
                $image = (!empty($product['image'])) ?
                    $product['image'] :
                    'unavailable.png';

                $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 107, 160);

                $link = $objUrl->href('catalog-item', [
                    'item',
                    $product['identity']
                ]);
            ?>
                <a
                    href="<?php echo $link; ?>"
                    class="product-image"
                    title="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                    >
                    <img
                        src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                        alt="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                        width="<?php echo $imageSize['width']; ?>"
                        height="<?php echo $imageSize['height']; ?>"
                        />
                </a>
                <div class="product-info-wrapper">
                    <div class="product-container">
                        <h2 class="product-name">
                            <a
                                href="<?php echo $link; ?>"
                                title="<?php echo Helper::encodeHTML(
                                    $product['name'], 1
                                ); ?>"
                                >
                                <?php echo Helper::encodeHTML($product['name'], 1); ?>
                            </a>
                        </h2>
                        <div class="price-box">
                            <span class="regular-price">
                                <span class="price">
                                    <?php echo $data['objCurrency']->display(
                                        number_format($product['price'], 2)
                                    ); ?>
                                </span>
                            </span>
                        </div>
                        <p>
                            <?php echo Basket::addRemoveCartButton($product['id']); ?>
                        </p>
                        <div class="product-desc">
                            <p>
                                <?php echo Helper::shortenString(
                                    Helper::encodeHTML($product['description']), 400
                                ); ?>
                            </p>
                            <a
                                href="<?php echo $link; ?>"
                                title="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                                class="link-learn"
                                >more</a>
                        </div>
                        <ul class="add-to-links">
                            <li><a href="" class="add-wishlist">Add to Wishlist</a></li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </li>
        <?php endforeach; ?>
        <div class="toolbar-bottom">
            <div class="toolbar">
                <div class="pager">
                    <p class="amount">
                        <?php echo $data['objCatalog']->getPagerAmountText(
                            $page, $productsCount, $productsPerPage, $productsOnPage
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
                                readonly="readonly"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="pages">
                        <?php if ($productsCount != 0): ?>
                        <?php echo $objPaging->getPaging(); ?>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </ol>
<?php else: ?>
    <?php if ($listing == 'section'): ?>
        <p>There are no products in this section.</p>
    <?php elseif ($listing == 'category'): ?>
        <p>There are no products in this category.</p>
    <?php endif; ?>
<?php endif; ?>