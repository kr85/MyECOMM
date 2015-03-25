<?php

use MyECOMM\Paging;
use MyECOMM\Catalog;

if (!empty($data['rows'])):
    unset($data['objUrl']->params['call']);
    $codesCount = count($data['rows']);
    $codesPerPage = 10;
    $objPaging = new Paging($data['objForm'], $data['rows'], $codesPerPage);
    $postCodes = $objPaging->getRecords();
    $codesOnPage = count($postCodes);
    $page = $data['objUrl']->get('pg');
    $page = (empty($page)) ? 1 : intval($page);

    $objCatalog = new Catalog();
?>
<fieldset>
    <table class="data-table">
        <thead>
            <tr>
                <th class="center" rowspan="1">
                    <span class="nobr">Post Code</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Remove</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($postCodes as $item): ?>
                <tr id="row-<?php $item['id']; ?>">
                    <td class="center">
                        <?php echo $item['country_code']; ?>
                    </td>
                    <td class="center">
                        <a
                            href="#"
                            class="click_add_row_confirm btn-remove-2"
                            data-url="<?php echo $data['objUrl']->getCurrent(
                                ['call', 'cid'],
                                false,
                                ['call', 'remove', 'cid', $item['id']]
                            ); ?>"
                            data-span="2"
                            >Remove</a>
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
                    $page, $codesCount, $codesPerPage, $codesOnPage
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
                <?php if ($codesCount != 0): ?>
                    <?php echo $objPaging->getPaging(); ?>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<?php else: ?>
<div class="center">
    <p class="empty">
        There are currently <strong>no post</strong> codes available.
    </p>
</div>
<?php endif; ?>
<div class="buttons-set">
    <a
        href="javascript:history.go(-1)"
        class="left back-btn">
        <small>« </small>Back
    </a>
</div>