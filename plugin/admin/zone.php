<?php

use MyECOMM\Helper;

if (!empty($data['rows'])): ?>
<table class="tbl_repeat">
    <thead>
        <tr>
            <th>Zone</th>
            <th class="col_1 ta_r">Post Codes</th>
            <th class="col_1 ta_r">Remove</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data['rows'] as $item): ?>
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
                <div class="text_small"><?php echo $item['country_codes']; ?></div>
            </td>
            <td class="ta_r">
                <a href="<?php echo $data['objUrl']->getCurrent(
                    ['action', 'id'],
                    false,
                    ['action', 'codes', 'id', $item['id']]
                ); ?>">Post Codes</a>
            </td>
            <td class="ta_r">
                <a
                    href="#"
                    class="click_add_row_confirm"
                    data-url="<?php echo $data['objUrl']->getCurrent(
                        ['action', 'id'],
                        false,
                        ['action', 'remove', 'id', $item['id']]
                    ); ?>"
                    data-span="3">Remove</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>There are currently no records.</p>
<?php endif; ?>