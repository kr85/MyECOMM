<?php

use MyECOMM\Catalog;
use MyECOMM\Paging;
use MyECOMM\Helper;

$objCatalog = new Catalog();
$sections = $objCatalog->getSectionsIncludeDefault();
$sectionsCount = count($sections);
$sectionsPerPage = 10;
$objPaging = new Paging($this->objUrl, $sections, $sectionsPerPage);
$rows = $objPaging->getRecords();
$sectionsOnPage = count($rows);
$page = $this->objUrl->get('pg');
$page = (empty($page)) ? 1 : intval($page);

require_once('_header.php'); ?>

<div class="listing section-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Sections
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Sections</h1>
    </div>
    <p class="btn-1-new-wrapper">
        <a
            href="<?php echo $this->objUrl->getCurrent(
                ['action','id'],
                false,
                ['action', 'add']
            ); ?>"
            class="btn-1"
        >
            <span>
                <span>New Section</span>
            </span>
        </a>
    </p>
    <?php if (!empty($rows)): ?>
    <fieldset>
        <table class="data-table">
            <tr>
                <th class="center" rowspan="1">
                    <span class="nobr">Section Name</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Edit Section</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Remove Section</span>
                </th>
            </tr>
            <?php foreach ($rows as $section): ?>
                <tr>
                    <td class="center">
                        <?php echo Helper::encodeHTML($section['name']); ?>
                    </td>
                    <td class="center">
                        <a
                            href="<?php echo $this->objUrl->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'edit', 'id', $section['id']]); ?>"
                            class="btn-edit-2"
                            title="Edit Section"
                            >
                            Edit
                        </a>
                    </td>
                    <td class="center">
                        <a
                            href="<?php echo $this->objUrl->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'remove', 'id', $section['id']]); ?>"
                            class="btn-remove-2"
                            title="Remove Section"
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
                    $page, $sectionsCount, $sectionsPerPage, $sectionsOnPage
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
                <?php if ($sectionsCount != 0): ?>
                    <?php echo $objPaging->getPaging(); ?>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="center pad-top-bottom-30">
            <p class="empty">
                There are currently <strong>no sections</strong> created.
            </p>
        </div>
    <?php endif; ?>
</div>

<?php require_once('_footer.php'); ?>