<?php
    $category = Url::getParam('category');

    if (empty($category))
    {
        require_once("error.php");
    }
    else
    {
        $objCatalogue = new Catalogue();
        $cat = $objCatalogue->getCategory($category);

        if (empty($cat))
        {
            require_once("error.php");
        }
        else
        {
            $rows = $objCatalogue->getProducts($cat);

            require_once("_header.php");
?>

    <h1>Catalogue :: <?php echo $cat['name']; ?></h1>

<?php
    if (!empty($rows))
    {
        foreach ($rows as $row)
        {
?>
            <div class="catalogue_wrapper">
                <div class="catalogue_wrapper_left">
                    <?php
                        $image = !empty($row['image']) ?
                        $objCatalogue->path.$row['image'] :
                        $objCatalogue->path.'unavailable.png';

                        $width = Helper::getImageSize($image, 0);
                        $width = $width > 120 ? 120 : $width;
                    ?>
                    <a href="/?page=catalogue-item&amp;category=<?php
                        echo $category['id']; ?>&amp;id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $image; ?>"
                             alt="<?php echo Helper::encodeHTML($row['name'], 1); ?>"
                             width="<?php echo $width; ?>" />
                    </a>
                </div>
                <div class="catalogue_wrapper_right">
                    <h4>
                        <a href="/?page=catalogue-item&amp;category=<?php
                            echo $category['id']; ?>&amp;id=<?php echo $row['id']; ?>">
                            <?php echo Helper::encodeHTML($row['name'], 1); ?>
                        </a>
                    </h4>
                    <h4>Price: <?php echo Catalogue::$currency;
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