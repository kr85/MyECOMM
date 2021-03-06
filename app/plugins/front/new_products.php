<?php

use MyECOMM\Helper;
use MyECOMM\Catalog;

$objCatalog = new Catalog();

?>
<div class="new-products">
    <?php if (!empty($data['latestProducts'])): ?>
        <?php foreach (array_chunk($data['latestProducts'], 6) as $row): ?>
            <ul class="row">
                <?php foreach ($row as $product): ?>
                    <li
                        id="<?php echo $product['id']; ?>"
                        class="product"
                    >
                        <?php
                        $image = (!empty($product['image'])) ?
                            $product['image'] :
                            'unavailable.png';

                        $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 107, 160);

                        $category = $objCatalog->getCategory($product['category']);

                        $link = $data['objUrl']->href('catalog-item', [
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
                                id="product-image-<?php echo $product['id']; ?>"
                                src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                                alt="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                                width="<?php echo $imageSize['width']; ?>"
                                height="<?php echo $imageSize['height']; ?>"/>
                        </a>
                        <h3 id="product-name-<?php echo $product['id']; ?>">
                            <a
                                href="<?php echo $link; ?>"
                                title="<?php echo Helper::encodeHTML($product['name'], 1); ?>"
                            >
                                <?php echo Helper::shortenString(
                                    Helper::encodeHTML($product['name'], 1), 50
                                ); ?>
                            </a>
                        </h3>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>