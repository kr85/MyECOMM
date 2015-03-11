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

?>
<div class="toolbar">
    <div class="pager">
        <p class="amount">
            <?php if ($productsCount <= $productsPerPage): ?>
                <?php echo $productsCount; ?> Item(s)
            <?php else: ?>
                Items
                <?php
                echo ($page * count($rows)) - $productsPerPage + 1;
                ?> to <?php
                echo ($page * count($rows));
                ?> of <?php
                echo $productsCount;
                ?> total
            <?php endif; ?>
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

                $width = Helper::getImageSize(CATALOG_PATH.DS.$image, 0);
                $width = ($width > 107) ? 107 : $width;

                $height = Helper::getImageSize(CATALOG_PATH.DS.$image, 1);
                $height = ($height > 160) ? 160 : $height;

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
                        width="<?php echo $width; ?>"
                        height="<?php echo $height; ?>"
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
            </li>
        <?php endforeach; ?>
        <div class="toolbar-bottom">
            <div class="toolbar">
                <div class="pager">
                    <p class="amount">
                        <?php if ($productsCount <= $productsPerPage): ?>
                            <?php echo $productsCount; ?> Item(s)
                        <?php else: ?>
                            Items
                            <?php
                            echo (($page * count($rows)) - $productsPerPage) + 1;
                            ?> to <?php
                            echo ($page * count($rows));
                            ?> of <?php
                            echo $productsCount;
                            ?> total
                        <?php endif; ?>
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