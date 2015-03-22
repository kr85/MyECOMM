<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Paging;

$objCatalog = new Catalog();

if (isset($_POST['search'])):
    if (!empty($_POST['search'])) {
        $url = $this->objUrl->getCurrent('search').'/search/'.urlencode(
                stripslashes($_POST['search'])
            );
    } else {
        $url = $this->objUrl->getCurrent('search');
    }
    Helper::redirect($url);
else:
    $search = stripslashes(urldecode($this->objUrl->get('search')));
    if (!empty($search)) {
        $products = $objCatalog->getAllProducts($search);
        $empty = 'There are <strong>no results</strong> matching your search criteria.';

    } else {
        $products = $objCatalog->getAllProducts();
        $empty = 'There are <strong>currently</strong> no records.';
    }

    $productsCount = count($products);
    $productsPerPage = 10;
    $objPaging = new Paging($this->objUrl, $products, $productsPerPage);
    $rows = $objPaging->getRecords();
    $productsOnPage = count($rows);
    $page = $this->objUrl->get('pg');
    $page = (empty($page)) ? 1 : intval($page);

    require_once('_header.php'); ?>

<div class="listing product-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Products
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Products</h1>
    </div>
    <div class="row">
        <div class="search-form-box">
            <form action="<?php echo $this->objUrl->getCurrent('search'); ?>"
                  method="POST">
                <table>
                    <tr>
                        <td>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="<?php echo $search; ?>"
                                class="fld"
                                placeholder="Find products..."
                            />
                        </td>
                        <td>
                            <button class="button" type="submit">
                                <span>
                                    <span>Search</span>
                                </span>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="btn-new-box">
            <p class="btn-1-new-wrapper">
                <a
                    href="<?php echo $this->objUrl->getCurrent(
                        ['action','id'],
                        false,
                        ['action', 'add']); ?>"
                    class="btn-1"
                    >
            <span>
                <span>New Product</span>
            </span>
                </a>
            </p>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php if (!empty($rows)): ?>
    <fieldset>
        <table class="data-table">
            <tr>
                <th class="center" rowspan="1">
                    <span class="nobr">Product Id</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Product Name</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Edit Product</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Remove Product</span>
                </th>
            </tr>
            <?php foreach ($rows as $product): ?>
            <tr>
                <td class="center">
                    <?php echo $product['id']; ?>
                </td>
                <td class="center">
                    <?php echo Helper::encodeHTML($product['name']); ?>
                </td>
                <td class="center">
                    <a
                        href="<?php echo $this->objUrl->getCurrent(
                            ['action', 'id'],
                            false,
                            ['action', 'edit', 'id', $product['id']]); ?>"
                        class="btn-edit-2"
                        title="Edit Product"
                        >
                        Edit
                    </a>
                </td>
                <td class="center">
                    <a
                        href="<?php echo $this->objUrl->getCurrent(
                            ['action', 'id'],
                            false,
                            ['action', 'remove', 'id', $product['id']]); ?>"
                        class="btn-remove-2"
                        title="Remove Product"
                        >
                        Remove
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>
    <div class="toolbar">
        <div class="pager">
            <p class="amount">
                <?php
        echo $objCatalog->getPagerAmountText(
            $page, $productsCount, $productsPerPage, $productsOnPage
        );
        ?>
            </p>
            <div class="page-number">
                <label for="page-num"><strong>Page: </strong></label>
                <div class="input-box">
                    <input
                        id="page-num"
                        onfocus="this.blur()"
                        type="text"
                        value="<?php echo $page; ?>"
                        readonly="readonly"
                        />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="pages">
            <?php if ($productsCount != 0): ?>
                <?php echo $objPaging->getPaging(); ?>
            <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="center pad-top-bottom-30">
        <p class="empty">
            <?php echo $empty; ?>
        </p>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php require_once('_footer.php'); ?>