<?php

use MyECOMM\Paging;
use MyECOMM\Helper;
use MyECOMM\Catalog;

$objCatalog = new Catalog();

if (!empty($data['rows'])):

    unset($data['objUrl']->params['action']);
    unset($data['objUrl']->params['id']);

    $countriesCount = count($data['rows']);
    $countriesPerPage = 10;
    $objPaging = new Paging($data['objUrl'], $data['rows'], $countriesPerPage);
    $countries = $objPaging->getRecords();
    $countriesOnPage = count($countries);
    $page = $data['objUrl']->get('pg');
    $page = (empty($page)) ? 1 : intval($page);
?>
<fieldset>
    <table class="data-table">
        <thead>
            <tr>
                <th class="center" rowspan="1" style="width: 300px">
                    <span class="nobr">Country</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Active</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Remove</span>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($countries as $item): ?>
            <tr id="row-<?php echo $item['id']; ?>">
                <td>
                    <span
                        class="click_hide_show nobr"
                        data-show="#name-<?php echo $item['id']; ?>"
                    >
                        <?php echo Helper::encodeHTML($item['name']); ?>
                    </span>
                    <input
                        type="text"
                        name="name-<?php echo $item['id']; ?>"
                        id="name-<?php echo $item['id']; ?>"
                        class="blur_update_hide_show dn"
                        data-id="<?php echo $item['id']; ?>"
                        value="<?php echo $item['name']; ?>"
                    />
                </td>
                <td class="center">
                    <a
                        href="#"
                        data-url="<?php echo $data['objUrl']->getCurrent(
                            ['action', 'id'],
                            false,
                            ['action', 'active', 'id', $item['id']]
                        ); ?>"
                        class="click_replace"
                    >
                        <?php echo ($item['include'] == 1) ? 'Yes' : 'No'; ?>
                    </a>
                </td>
                <td class="center">
                    <a
                        href="#"
                        data-url="<?php echo $data['objUrl']->getCurrent(
                            ['action', 'id'],
                            false,
                            ['action', 'remove', 'id', $item['id']]
                        ); ?>"
                        class="click_add_row_confirm btn-remove-2"
                        data-span="3"
                    >
                        Remove
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>
<div class="toolbar">
    <div class="pager">
        <p class="amount">
            <?php
                echo $objCatalog->getPagerAmountText(
                    $page, $countriesCount, $countriesPerPage, $countriesOnPage
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
            <?php if ($countriesCount != 0): ?>
                <?php echo $objPaging->getPaging(); ?>
            <?php endif; ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="center">
    <p class="empty">
        There are currently <strong>no records</strong> available.
    </p>
</div>
<?php endif; ?>