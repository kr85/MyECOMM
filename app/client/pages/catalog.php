<?php

use MyECOMM\Catalog;
use MyECOMM\Paging;
use MyECOMM\Helper;
use MyECOMM\Basket;

$category = $this->objUrl->get('category');

if (empty($category)):
    require_once("error.php");
else:
    // Instantiate catalog class
    $objCatalog = new Catalog();
    $category = $objCatalog->getCategoryByIdentity($category);

    if (empty($category)):
        require_once("error.php");
    else:
        $this->metaTitle = $category['meta_title'];
        $this->metaDescription = $category['meta_description'];
        // Get all products of a category
        $rows = $objCatalog->getProducts($category['id']);
        // Instantiate paging class
        $objPaging = new Paging($this->objUrl, $rows, 3);
        $rows = $objPaging->getRecords();

        require_once("_header.php");
        ?>

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

                        $link = $this->objUrl->href(
                            'catalog-item',
                            [
                                'category',
                                $category['identity'],
                                'item',
                                $row['identity']
                            ]
                        );
                    ?>
                    <a href="<?php echo $link; ?>"> <img
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
endif;
?>