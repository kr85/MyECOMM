<?php

use MyECOMM\Catalog;
use MyECOMM\Basket;
use MyECOMM\Helper;
use MyECOMM\Session;
use MyECOMM\Plugin;

$id = $this->objUrl->get('item');

// Check if id is empty
if (!empty($id)):
    $objCatalog = new Catalog();
    $product = $objCatalog->getProductByIdentity($id);

    // Check if product is empty
    if (!empty($product)):
        $this->metaTitle = $product['meta_title'];
        $this->metaDescription = $product['meta_description'];

        // Get product's category and section
        $category = $objCatalog->getCategory($product['category']);
        $section = $objCatalog->getSection($product['section']);
        if (!empty($section) && empty($category)) {
            $pRand = $objCatalog->getProductsBySection($product['section']);
            $pRandKeys = array_rand($pRand, 6);
        } else {
            $pRand = $objCatalog->getProductsByCategory($product['section']);
            $pRandKeys = array_rand($pRand, 6);
        }

        // Save the product as recently viewed
        Session::setRecentlyViewed($product['id'], $product);

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
                <?php if (!empty($section)): ?>
                <li class="section">
                    <a
                        href="<?php echo $this->objUrl->href('catalog', [
                            'section',
                            $section['identity']
                        ]); ?>"
                        title="Go to <?php
                            echo Helper::encodeHTML($section['name']);
                        ?> Section"
                    >
                        <?php echo Helper::encodeHTML($section['name']); ?>
                    </a>
                    <span>&nbsp;</span>
                </li>
                <?php endif; ?>
                <?php if (!empty($category)): ?>
                    <li class="category">
                        <a
                            href="<?php echo $this->objUrl->href('catalog', [
                                'category',
                                $category['identity']
                            ]); ?>"
                            title="Go to <?php
                            echo Helper::encodeHTML($category['name']);
                            ?> Category"
                            >
                            <?php echo Helper::encodeHTML($category['name']); ?>
                        </a>
                        <span>&nbsp;</span>
                    </li>
                <?php endif; ?>
                <li>
                    <strong>
                        <?php echo Helper::encodeHTML($product['name']); ?>
                    </strong>
                </li>
            </ul>
        </div>
        <div class="product-view">
            <div class="product-essential">
                <form action="">
                    <div class="product-info-wrapper">
                        <div class="product-name">
                            <h1>
                                <?php echo Helper::encodeHTML($product['name']); ?>
                            </h1>
                        </div>
                        <div class="price-box">
                            <span class="regular-price">
                                <span class="price">
                                    <?php echo $this->objCurrency->display(
                                        $product['price']
                                    ); ?>
                                </span>
                            </span>
                        </div>
                        <p class="availability in-stock">
                            Availability:
                            <span>In Stock</span>
                        </p>
                        <div class="add-to-box">
                            <div class="add-to-cart">
                                <label for="qty">Qty:</label>
                                <input
                                    type="number"
                                    id="qty"
                                    name="qty"
                                    class="input-text qty"
                                    title="Qty"
                                    maxlength="12"
                                    min="1"
                                    step="1"
                                    value="<?php
                                        $qty = Basket::getItemQty($product['id']);
                                        if (!empty($qty)):
                                            echo $qty;
                                        else:
                                            echo 1;
                                        endif;
                                    ?>"
                                    required="required"
                                    pattern="[0-9+]"
                                />
                                <div class="clearfix"></div>
                                <p class="add-btn-wrapper">
                                    <?php echo Basket::addRemoveCartButton($product['id']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="product-image-box">
                        <p class="product-image">
                        <?php
                            $image = (!empty($product['image'])) ?
                                $product['image'] :
                                'unavailable.png';

                            $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 130, 195);

                        ?>
                            <img
                                src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                                alt="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                                title="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                                width="<?php echo $imageSize['width']; ?>"
                                height="<?php echo $imageSize['height']; ?>"
                            />
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <div class="product-collateral">
                <div class="box-collateral box-description">
                    <h2>Description</h2>
                    <p class="product-details">
                        <?php echo Helper::encodeHTML($product['description']); ?>
                    </p>
                </div>
                <div class="box-collateral box-up-sell">
                    <h2>You may also be interested in the following product(s)</h2>
                    <ul class="products-grid-upsell">
                        <?php
                            foreach ($pRandKeys as $key):
                                $image = (!empty($pRand[$key]['image'])) ?
                                    $pRand[$key]['image'] :
                                    'unavailable.png';

                                $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 95, 142);

                                $link = $this->objUrl->href('catalog-item', [
                                    'item',
                                    $pRand[$key]['identity']
                                ]);
                        ?>
                        <li class="item">
                            <a
                                href="<?php echo $link; ?>"
                                class="product-image"
                                title="<?php echo Helper::encodeHTML($pRand[$key]['name'], 1); ?>"
                            >
                                <img
                                    src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                                    alt="<?php echo Helper::encodeHTML($pRand[$key]['name'], 1); ?>"
                                    title="<?php echo Helper::encodeHTML($pRand[$key]['name'], 1); ?>"
                                    width="<?php echo $imageSize['width']; ?>"
                                    height="<?php echo $imageSize['height']; ?>"
                                />
                            </a>
                            <div class="up-holder">
                                <h3 class="product-name">
                                    <a
                                        href="<?php echo $link; ?>"
                                        title="<?php echo Helper::encodeHTML($pRand[$key]['name'], 1); ?>"
                                    >
                                            <?php echo Helper::shortenString(
                                                Helper::encodeHTML(
                                                    $pRand[$key]['name'], 1), 30
                                            ); ?>
                                    </a>
                                </h3>
                                <div class="price-box">
                                    <span class="regular-price">
                                        <span class="price">
                                            <?php echo $this->objCurrency->display(
                                                $pRand[$key]['price']
                                            ); ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-right sidebar">
        <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
            'objUrl' => $this->objUrl,
            'objCurrency' => $this->objCurrency,
            'objCatalog' => $objCatalog,
            'listing' => 'category',
            'id' => $category['id'],
            'productId' => $product['id']
        ]); ?>
    </div>
    <div class="clearfix"></div>
</div>
<?php require_once('_footer.php');
    else:
        require_once('error.php');
    endif;
else:
    require_once('error.php');
endif;