<?php

use MyECOMM\Plugin;
use MyECOMM\Helper;
use MyECOMM\Session;

$recentlyViewed = Session::getSession('recentlyViewed');
$listing = $data['listing'];
if ($listing == 'section') {
    $products = $data['objCatalog']->getProductsBySection($data['id']);
    $pRandKeys = array_rand($products, 3);
} else {
    $products = $data['objCatalog']->getProductsByCategory($data['id']);
    $pRandKeys = array_rand($products, 3);
}
if (!empty($products)):
?>

<?php if ($data['productId'] != 0): ?>
<div class="block block-related">
    <div class="block-title">
        <strong>
            <span>Related Products</span>
        </strong>
    </div>
    <div class="block-content">
        <p class="block-subtitle">
            Check items to add to the cart
        </p>
        <ol class="mini-products-list">
            <?php
                foreach ($pRandKeys as $key):
                    $image = (!empty($products[$key]['image'])) ?
                        $products[$key]['image'] :
                        'unavailable.png';

                    $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 85, 127);

                    $link = $data['objUrl']->href('catalog-item', [
                        'item',
                        $products[$key]['identity']
                    ]);
            ?>
            <li class="item">
                <div class="product">
                    <a
                        href="<?php echo $link; ?>"
                        class="product-image"
                        title="<?php echo Helper::encodeHTML($products[$key]['name'], 1); ?>"
                    >
                        <img
                            src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                            alt="<?php echo Helper::encodeHTML($products[$key]['name'], 1); ?>"
                            title="<?php echo Helper::encodeHTML($products[$key]['name'], 1); ?>"
                            width="<?php echo $imageSize['width']; ?>"
                            height="<?php echo $imageSize['height']; ?>"
                        />
                    </a>
                    <div class="product-details">
                        <p class="product-name">
                            <a
                                href="<?php echo $link; ?>"
                                title="<?php echo Helper::encodeHTML($products[$key]['name'], 1); ?>"
                            >
                                <?php echo Helper::shortenString(
                                    Helper::encodeHTML($products[$key]['name'], 1),
                                    45
                                ); ?>
                            </a>
                        </p>
                        <div class="price-box">
                            <span class="regular-price">
                                <span class="price">
                                    <?php echo $data['objCurrency']->display(
                                        $products[$key]['price']
                                    ); ?>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </li>
            <div class="clearfix"></div>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<?php endif; ?>
<div class="block block-layered-nav">
    <div class="block-title">
        <strong>
            <span>Shop By</span>
        </strong>
    </div>
    <div class="block-content">
        <p class="block-subtitle">Shopping Options</p>
        <dl>
        <?php
            if ($listing == 'section'):
                $categories = $data['objCatalog']->getCategoriesBySection(
                    $data['id']
                );
                if (!empty($categories)):
        ?>
        <dt>Category</dt>
        <dd>
            <ol>
            <?php
                foreach ($categories as $category):
                    $link = $data['objUrl']->href('catalog', [
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
            </ol>
        </dd>
                <?php endif; ?>
            <?php endif; ?>
        <?php
            $links = $data['objCatalog']->getProductsByPriceLinks(
                $data['id'], $listing
            );
            if (!empty($links)):
        ?>
            <dt>Price</dt>
            <dd>
                <ol>
                <?php foreach ($links as $link):
                    echo $link;
                endforeach; ?>
                </ol>
            </dd>
            <?php endif; ?>
        </dl>
    </div>
</div>
<?php endif; ?>
<div id="my-cart-small">
    <?php echo Plugin::get('front'.DS.'cart_left', [
        'objUrl' => $data['objUrl'],
        'objCurrency' => $data['objCurrency'],
        'objCatalog' => $data['objCatalog'],
    ]); ?>
</div>
<?php if (!empty($recentlyViewed)): ?>
<div class="block block-viewed">
    <div class="block-title">
        <strong>
            <span>Recently Viewed Products</span>
        </strong>
    </div>
    <div class="block-content">
        <ol id="recently-viewed-items">
            <?php
                foreach (array_reverse($recentlyViewed) as $key => $array):
                    $link = $data['objUrl']->href('catalog-item', [
                        'item',
                        $array['identity']
                    ]);
            ?>
            <li class="item">
                <p class="product-name">
                    <a
                        href="<?php echo $link; ?>"
                        title="<?php echo Helper::encodeHTML($array['name']); ?>"
                    >
                        <?php echo Helper::encodeHTML($array['name']); ?>
                    </a>
                </p>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<?php endif; ?>
<div class="paypal-logo">
    <a
        href="#"
        title="Additional Options"
        onclick="window.open('https://www.paypal.com/us/' +
                           'cgi-bin/webscr?cmd=xpt/Marketing/popup/' +
                           'OLCWhatIsPayPal-outside',
                        'paypal', 'width=800,' +
                                  'height=550,' +
                                  'left=0,' +
                                  'top=0,' +
                                  'location=no,' +
                                  'status=yes,' +
                                  'scrollbars=yes,' +
                                  'resizable=yes');
                        return false;"
        >
        <img
            src="<?php echo DS.ASSETS_DIR.DS.IMAGES_DIR.DS.'paypal.gif'; ?>"
            alt="Additional Options"
            title="Additional Options"/>
    </a>
</div>