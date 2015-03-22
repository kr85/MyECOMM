<?php

use MyECOMM\Catalog;
use MyECOMM\Paging;
use MyECOMM\Helper;

$objCatalog = new Catalog();
$categories = $objCatalog->getCategories();
$categoriesCount = count($categories);
$categoriesPerPage = 10;
$objPaging = new Paging($this->objUrl, $categories, $categoriesPerPage);
$rows = $objPaging->getRecords();
$categoriesOnPage = count($rows);
$page = $this->objUrl->get('pg');
$page = (empty($page)) ? 1 : intval($page);

require_once('_header.php'); ?>

<div class="listing category-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="categories">
                <strong>
                    Categories
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Categories</h1>
    </div>
    <p class="btn-1-new-wrapper">
        <a
            href="<?php echo $this->objUrl->getCurrent(
                ['action','id'],
                false,
                ['action', 'add']); ?>"
            class="btn-1"
        >
            <span>
                <span>New Category</span>
            </span>
        </a>
    </p>
    <?php if (!empty($rows)): ?>
    <fieldset>
        <table class="data-table">
            <tr>
                <th class="center" rowspan="1">
                    <span class="nobr">Category Name</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Edit Category</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Remove Category</span>
                </th>
            </tr>
            <?php foreach ($rows as $category): ?>
                <tr>
                    <td class="center">
                        <?php echo Helper::encodeHTML($category['name']); ?>
                    </td>
                    <td class="center">
                        <a
                            href="<?php echo $this->objUrl->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'edit', 'id', $category['id']]); ?>"
                            class="btn-edit-2"
                            title="Edit Category"
                        >
                            Edit
                        </a>
                    </td>
                    <td class="center">
                        <a
                            href="<?php echo $this->objUrl->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'remove', 'id', $category['id']]); ?>"
                            class="btn-remove-2"
                            title="Remove Category"
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
                    $page, $categoriesCount, $categoriesPerPage, $categoriesOnPage
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
                <?php if ($categoriesCount != 0): ?>
                    <?php echo $objPaging->getPaging(); ?>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="center pad-top-bottom-30">
            <p class="empty">
                There are currently <strong>no categories</strong> created.
            </p>
        </div>
    <?php endif; ?>
</div>

<?php require_once('_footer.php'); ?>