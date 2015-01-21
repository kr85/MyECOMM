<?php
    $category = Url::getParam('category');

    if (empty($category))
    {
        require_once("error.php");
    }
    else
    {
        // Instantiate catalog class
        $objCatalog = new Catalog();
        $category = $objCatalog->getCategory($category);

        if (empty($category))
        {
            require_once("error.php");
        }
        else
        {
            $rows = $objCatalog->getProducts($category);

            // Instantiate paging class
            $objPaging = new Paging($rows, 3);
            $rows = $objPaging->getRecords();

            require_once("_header.php");
?>

            <h1 xmlns="http://www.w3.org/1999/html">Catalog :: <?php echo $category['name']; ?></h1>

<?php
    if (!empty($rows))
    {
        foreach ($rows as $row)
        {
?>
            <div class="catalog_wrapper">
                <div class="catalog_wrapper_left">
                    <?php
                        $image = !empty($row['image']) ?
                        $objCatalog->path.$row['image'] :
                        $objCatalog->path.'unavailable.png';

                        $width = Helper::getImageSize($image, 0);
                        $width = $width > 120 ? 120 : $width;
                    ?>
                    <a href="/?page=catalog-item&amp;category=<?php
                        echo $category['id']; ?>&amp;id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $image; ?>"
                             alt="<?php echo Helper::encodeHTML($row['name'], 1); ?>"
                             width="<?php echo $width; ?>" />
                    </a>
                </div>
                <div class="catalog_wrapper_right">
                    <h4>
                        <a href="/?page=catalog-item&amp;category=<?php
                            echo $category['id']; ?>&amp;id=<?php echo $row['id']; ?>">
                            <?php echo Helper::encodeHTML($row['name'], 1); ?>
                        </a>
                    </h4>
                    <h4>Price: <?php echo Catalog::$currency;
                        echo number_format($row['price'], 2); ?>
                    </h4>
                    <p>
                        <?php echo Helper::shortenString(
                                Helper::encodeHTML($row['description'])
                            );
                        ?>
                    </p>
                    <p>
                        <p><?php echo Basket::activeButton($row['id']); ?></p>
                    </p>
                </div>
            </div>
<?php
        }

        // Display pagination links
        echo $objPaging->getPaging();
    }
    else
    {
?>
        <p>There are no products in this category.</p>
<?php
    }
            require_once("_footer.php");
        }
    }
?>