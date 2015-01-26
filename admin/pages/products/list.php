<?php

    $objCatalog = new Catalog();
    $search = Url::getParam('srch');

    if (!empty($search)) {
        $products = $objCatalog->getAllProducts($search);
        $empty = 'There are no results matching your search criteria.';

    } else {
        $products = $objCatalog->getAllProducts();
        $empty = 'There are currently no records.';
    }

    $objPaging = new Paging($products, 5);
    $rows = $objPaging->getRecords();
    $objPaging->url = '/admin' . $objPaging->url;

    require_once('templates/_header.php'); ?>

    <h1>Products</h1>

    <form action="" method="GET">
        <?php echo Url::getParamsForSearch('srch', Paging::$key); ?>
        <table cellspacing="0" cellpadding="0" border="0" class="tbl_insert">
            <tr>
                <th>
                    <label for="srch">
                        Products:
                    </label>
                </th>
                <td>
                    <input type="text" name="srch" id="srch"
                           value="<?php echo stripslashes($search); ?>"
                           class="fld"/>
                </td>
                <td>
                    <label for="btn_add" class="sbm sbm_blue fl_l">
                        <input type="submit" id="btn_add" class="btn"
                               value="Search"/>
                    </label>
                </td>
            </tr>
        </table>
    </form>

    <div class="dev br_td">&#160;</div>

    <p>
        <a href="/admin/?page=products&amp;action=add">
            New Product
        </a>
    </p>

<?php
    if (!empty($rows)) {
        ?>
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
            <tr>
                <th class="col_15">Id</th>
                <th>Product</th>
                <th class="ta_r col_15">Remove</th>
                <th class="ta_r col_15">Edit</th>
            </tr>
            <?php foreach ($rows as $product) { ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo Helper::encodeHTML($product['name']); ?></td>
                    <td class="ta_r">
                        <a href="/admin/?page=products&amp;action=remove&amp;id=<?php echo $product['id']; ?>">
                            Remove
                        </a>
                    </td>
                    <td class="ta_r">
                        <a href="/admin/?page=products&amp;action=edit&amp;id=<?php echo $product['id']; ?>">
                            Edit
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php echo $objPaging->getPaging(); ?>

    <?php
    } else {
        echo '<p>' . $empty . '</p>';
    }
?>

<?php require_once('templates/_footer.php'); ?>