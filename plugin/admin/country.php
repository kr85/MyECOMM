<?php

use MyECOMM\Paging;
use MyECOMM\Helper;

if (!empty($data['rows'])):

    unset($data['objUrl']->params['action']);
    unset($data['objUrl']->params['id']);

    $objPaging = new Paging($data['objUrl'], $data['rows'], 10);
    $countries = $objPaging->getRecords();
?>
<table class="tbl_repeat">
    <thead>
        <tr>
            <th>Country</th>
            <th class="col_1 ta_r">Active</th>
            <th class="col_1 ta_r">Remove</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($countries as $item): ?>
        <tr id="row-<?php echo $item['id']; ?>">
            <td>
                <span
                    class="click_hide_show"
                    data-show="#name-<?php echo $item['id']; ?>"
                >
                    <?php echo Helper::encodeHTML($item['name']); ?>
                </span>
                <input
                    type="text"
                    name="name-<?php echo $item['id']; ?>"
                    id="name-<?php echo $item['id']; ?>"
                    class="fld blur_update_hide_show dn"
                    data-id="<?php echo $item['id']; ?>"
                    value="<?php echo $item['name']; ?>"
                />
            </td>
            <td class="ta_r">
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
            <td class="ta_r">
                <a
                    href="#"
                    data-url="<?php echo $data['objUrl']->getCurrent(
                        ['action', 'id'],
                        false,
                        ['action', 'remove', 'id', $item['id']]
                    ); ?>"
                    class="click_add_row_confirm"
                    data-span="3"
                >
                    Remove
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php echo $objPaging->getPaging(); ?>
<?php else: ?>
<p>There are currently no records available.</p>
<?php endif; ?>