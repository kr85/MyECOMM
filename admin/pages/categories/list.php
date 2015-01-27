<?php

    $objCatalog = new Catalog();
    $categories = $objCatalog->getCategories();

    $objPaging = new Paging($categories, 5);
    $rows = $objPaging->getRecords();
    $objPaging->url = '/admin' . $objPaging->url;

    require_once('templates/_header.php'); ?>

    <h1>Categories</h1>

    <p>
        <a href="/admin/?page=categories&amp;action=add">
            New Category
        </a>
    </p>

<?php if (!empty($rows)) { ?>

    <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
        <tr>
            <th>Category</th>
            <th class="ta_r col_15">Remove</th>
            <th class="ta_r col_15">Edit</th>
        </tr>
        <?php foreach ($rows as $category) { ?>
            <tr>
                <td><?php echo Helper::encodeHTML($category['name']); ?></td>
                <td class="ta_r">
                    <a href="/admin/?page=categories&amp;action=remove&amp;id=<?php
                        echo $category['id']; ?>">
                        Remove
                    </a>
                </td>
                <td class="ta_r">
                    <a href="/admin/?page=categories&amp;action=edit&amp;id=<?php
                        echo $category['id']; ?>">
                        Edit
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php echo $objPaging->getPaging(); ?>

<?php } else { ?>
    <p>There are currently no categories created.</p>
<?php } ?>

<?php require_once('templates/_footer.php'); ?>