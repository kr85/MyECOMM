<?php

use MyECOMM\Basket;
use MyECOMM\Session;
USE MyECOMM\Helper;

// Instantiate basket class
$objBasket = (is_object($objBasket)) ? $objBasket : new Basket();

?>

<div class="block">
    <div class="block-title">
        <strong>
            <span>My Cart</span>
        </strong>
    </div>
    <div class="block-content">
        <?php if ($objBasket->numberOfItems > 0): ?>
            <div class="summary">
                <p class="amount">
                    <?php
                        $summaryAmount = Session::getSession('summaryAmount');
                        if (empty($summaryAmount)) {
                            $summaryAmount = $data['summaryAmount'];
                        }
                        echo $summaryAmount;
                    ?>
                </p>
                <p class="subtotal">
                    <span class="label">Cart Subtotal:</span>
                    <span class="price bl_st">
                        <?php echo $data['objCurrency']->display(
                            number_format($objBasket->subTotal, 2)
                        ); ?>
                    </span>
                </p>
            </div>
            <p class="block-subtitle">
                Recently added item(s)
            </p>
            <ol class="mini-products-list">
                <?php
                    foreach ($objBasket->productsInfo as $product):

                        $image = (!empty($product['image'])) ?
                            $product['image'] :
                            'unavailable.png';

                        $width = Helper::getImageSize(CATALOG_PATH.DS.$image, 0);
                        $width = ($width > 50) ? 50 : $width;

                        $height = Helper::getImageSize(CATALOG_PATH.DS.$image, 1);
                        $height = ($height > 71) ? 71 : $height;

                        $category = $data['objCatalog']->getCategory($product['category']);

                        $link = $data['objUrl']->href('catalog-item', [
                            'category',
                            $category['identity'],
                            'item',
                            $product['identity']
                        ]);
                ?>
                    <li class="item" title="<?php echo Helper::encodeHTML($product['name'], 1); ?>">
                        <a href="<?php echo $link; ?>" class="product-image">
                            <img
                                src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                                alt="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                                width="<?php echo $width; ?>"
                                height="<?php echo $height; ?>"
                                title="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                            />
                        </a>
                        <div class="product-details">
                            <?php echo Basket::removeButtonSmallCart($product['id']); ?>
                            <a href="<?php echo $data['objUrl']->href('basket'); ?>" class="btn-edit">
                                Edit Item
                            </a>
                            <p class="product-name">
                                <a href="<?php echo $link; ?>">
                                    <?php echo Helper::shortenString(
                                        Helper::encodeHTML($product['name'], 1),
                                        30);
                                    ?>
                                </a>
                            </p>
                            <strong>
                                <?php echo $product['quantity']; ?>
                            </strong>
                            x
                            <span class="price"><?php echo $product['price']; ?></span>
                        </div>
                    </li>
                    <div class="clearfix"></div>
                <?php endforeach; ?>
            </ol>
            <div class="actions">

            </div>
        <?php else: ?>
            <p class="empty">You have <strong>no items</strong> in your shopping cart.</p>
        <?php endif; ?>
    </div>
</div>