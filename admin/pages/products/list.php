<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Paging;

$objCatalog = new Catalog();

if (isset($_POST['search'])) {
    if (!empty($_POST['search'])) {
        $url = $this->objUrl->getCurrent('search').'/search/'.urlencode(
                stripslashes($_POST['search'])
            );
    } else {
        $url = $this->objUrl->getCurrent('search');
    }
    Helper::redirect($url);
} else {
    $search = stripslashes(urldecode($this->objUrl->get('search')));
    if (!empty($search)) {
        $products = $objCatalog->getAllProducts($search);
        $empty = 'There are no results matching your search criteria.';

    } else {
        $products = $objCatalog->getAllProducts();
        $empty = 'There are currently no records.';
    }

    $objPaging = new Paging($this->objUrl, $products, 5);
    $rows = $objPaging->getRecords();

    require_once('_header.php'); ?>

    <h1>Products</h1>

    <form action="<?php echo $this->objUrl->getCurrent('search'); ?>"
          method="POST">
        <table class="tbl_insert">
            <tr>
                <th>
                    <label for="search"> Products: </label>
                </th>
                <td>
                    <input type="text" name="search" id="search"
                           value="<?php echo $search; ?>" class="fld"/>
                </td>
                <td>
                    <label for="btn_add" class="sbm sbm_blue fl_l">
                        <input type="submit" id="btn_add" class="btn" value="Search"/>
                    </label>
                </td>
            </tr>
        </table>
    </form>

    <div class="dev br_td">&#160;</div>

    <p>
        <a href="<?php echo $this->objUrl->getCurrent(
                'action'
            ).'/action/add'; ?>">New Product</a>
    </p>

    <?php
    if (!empty($rows)): ?>
        <table class="tbl_repeat">
            <tr>
                <th class="col_15">Id</th>
                <th>Product</th>
                <th class="ta_r col_15">Remove</th>
                <th class="ta_r col_15">Edit</th>
            </tr>
            <?php foreach ($rows as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo Helper::encodeHTML($product['name']); ?></td>
                    <td class="ta_r">
                        <a href="<?php echo $this->objUrl->getCurrent(
                                'action'
                            ).'/action/remove/id/'.$product['id']; ?>">
                            Remove </a>
                    </td>
                    <td class="ta_r">
                        <a href="<?php echo $this->objUrl->getCurrent(
                                'action'
                            ).'/action/edit/id/'.$product['id']; ?>">
                            Edit </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php echo $objPaging->getPaging(); ?>

    <?php else:
        echo '<p>'.$empty.'</p>';
    endif;

    require_once('_footer.php');
} ?>