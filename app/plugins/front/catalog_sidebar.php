<?php

use MyECOMM\Plugin;
use MyECOMM\Helper;
use MyECOMM\Session;

$recentlyViewed = Session::getSession('recentlyViewed');
$listing = $data['listing'];
if ($listing == 'section') {
    $products = $data['objCatalog']->getProductsBySection($data['id']);
} else {
    $products = $data['objCatalog']->getProductsByCategory($data['id']);
}
if (!empty($products)):
?>

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
    <?php echo Plugin::get('front'.DS.'basket_left', [
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
                    $cat = $data['objCatalog']->getCategory($array['category']);
                    $link = $data['objUrl']->href('catalog-item', [
                        'category',
                        $cat['identity'],
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