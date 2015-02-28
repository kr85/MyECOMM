<?php

use MyECOMM\Paging;

if (!empty($data['rows'])):
    unset($data['objUrl']->params['call']);
    $objPaging = new Paging($data['objForm'], $data['rows'], 10);
    $postCodes = $objPaging->getRecords();
?>
<table class="tbl_repeat">
    <thead>
        <tr>
            <th>Post Code</th>
            <th class="col_1 ta_r">Remove</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($postCodes as $item): ?>
        <tr id="row-<?php $item['id']; ?>">
            <td>
                <?php echo $item['country_code']; ?>
            </td>
            <td class="ta_r">
                <a
                    href="#"
                    class="click_add_row_confirm"
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
<?php echo $objPaging->getPaging(); ?>
<?php else: ?>
<p>There are currently no post codes available.</p>
<?php endif; ?>