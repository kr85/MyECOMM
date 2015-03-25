<?php

use MyECOMM\Helper;

if (!empty($data['rows'])): ?>
<fieldset>
    <table class="data-table">
        <thead>
            <tr>
                <th class="center" rowspan="1" style="width: 395px;">
                    <span class="nobr">Zone</span>
                </th>
                <th class="center" rowspan="1" style="width: 90px">
                    <span class="nobr">Post Codes</span>
                </th>
                <th class="center" rowspan="1" style="width: 90px">
                    <span class="nobr">Remove</span>
                </th>
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
                    <td class="center">
                        <a href="<?php echo $data['objUrl']->getCurrent(
                            ['action', 'id'],
                            false,
                            ['action', 'codes', 'id', $item['id']]
                        ); ?>"
                            class="btn-view"
                        >Post Codes</a>
                    </td>
                    <td class="center">
                        <a
                            href="#"
                            class="click_add_row_confirm btn-remove-2"
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
</fieldset>
<?php else: ?>
<div class="center">
    <p class="empty">
        There are currently <strong>no records</strong> available.
    </p>
</div>
<?php endif; ?>