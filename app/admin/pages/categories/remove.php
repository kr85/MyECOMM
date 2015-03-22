<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Paging;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objCatalog = new Catalog();
    $category = $objCatalog->getCategory($id);

    if (!empty($category)) {

        $yes = $this->objUrl->getCurrent().'/remove/1';
        $no = 'javascript:history.go(-1)';

        $remove = $this->objUrl->get('remove');

        if (!empty($remove) && $category['products_count'] == 0) {
            $objCatalog->removeCategory($id);

            Helper::redirect(
                $this->objUrl->getCurrent([
                    'action',
                    'id',
                    'remove',
                    'search',
                    Paging::$key
                ]));
        }

        require_once('_header.php'); ?>
<div class="listing category-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="categories">
                <a href="/panel/categories" title="Go to Categories">Categories</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Remove
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Categories :: Remove</h1>
    </div>
    <p class="remove-yes-no">
        Are you sure you want to remove this category?
        <a href="<?php echo $yes; ?>">Yes</a> |
        <a href="<?php echo $no; ?>">No</a>
    </p>
</div>
        <?php
        require_once('_footer.php');
    }
}
?>