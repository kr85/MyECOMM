<?php

    $id = $this->objUrl->get('item');

    // Check if id is empty
    if (!empty($id)) {
        $objCatalog = new Catalog();
        $product = $objCatalog->getProductByIdentity($id);

        // Check if product is empty
        if (!empty($product)) {
            $this->metaTitle = $product['meta_title'];
            $this->metaDescription = $product['meta_description'];
            $this->metaKeywords = $product['meta_keywords'];

            // Get product's category
            $category = $objCatalog->getCategory($product['category']);

            require_once('_header.php');

            echo "<h1>Catalog :: " . $category['name'] . "</h1>";

            $image = !empty($product['image']) ?
                $product['image'] :
                'unavailable.png';

            // Check if image is empty
            if (!empty($image)) {
                $width = Helper::getImageSize(CATALOG_PATH . DS . $image, 0);
                $width = $width > 120 ?
                    120 :
                    $width;
                echo "<div class=\"fl_l\">";
                echo "<div class=\"lft\"><img src=\"";
                echo $objCatalog->path . $image;
                echo "\" alt=\"";
                echo Helper::encodeHTML($product['name'], 1);
                echo "\" width=\"{$width}\" /></div>";
            }

            echo "<div class=\"rgt\"><h3>" . $product['name'] . "</h3>";
            echo "<h4><strong>" . Catalog::$currency;
            echo $product['price'] . "</strong></h4>";
            echo Basket::activeButton($product['id']);
            echo "</div></div>";
            echo "<div class=\"dev\">&#160;</div>";
            echo "<p>" . Helper::encodeHTML($product['description']) . "</p>";
            echo "<div class=\"dev br_td\">&#160;</div>";
            echo "<p><a href=\"javascript:history.go(-1)\">Go back</a></p>";

            require_once('_footer.php');
        } else {
            require_once('error.php');
        }
    } else {
        require_once('error.php');
    }