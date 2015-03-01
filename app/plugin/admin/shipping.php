<?php

use MyECOMM\Helper;

if (!empty($data['rows'])): ?>
<table class="tbl_repeat">
    <thead>
        <tr>
            <th class="col_1">+</th>
            <th>Type</th>
            <th class="col_1">Rates</th>
            <th class="col_1">Active</th>
            <th class="col_1">Default</th>
            <th class="col_1">Duplicate</th>
            <th class="col_1 ta_r">Remove</th>
        </tr>
    </thead>
    <tbody id="rowsLocal" class="sort_rows" data-url="<?php
        echo $data['urlSort'];
    ?>">
        <?php foreach($data['rows'] as $item): ?>
            <tr id="row-<?php echo $item['id']; ?>">
                <td>+</td>
                <td>
                    <span class="click_hide_show"
                          data-show="#name-<?php echo $item['id']; ?>">
                        <?php echo Helper::encodeHTML($item['name']); ?>
                    </span>
                    <input
                        type="text"
                        name="name-<?php echo $item['id']; ?>"
                        id="name-<?php echo $item['id']; ?>"
                        class="fld fld_list blur_update_hide_show dn"
                        data-id="<?php echo $item['id']; ?>"
                        value="<?php echo $item['name']; ?>"
                    />
                </td>
                <td>
                    <select name="rate-<?php echo $item['id']; ?>"
                            id="rate-<?php echo $item['id']; ?>"
                            class="fld fld_small select_redirect">
                        <option value="">Edit Rates</option>
                        <?php if (!empty($data['countries'])): ?>
                            <?php foreach ($data['countries'] as $crow): ?>
                                <option value="<?php echo $crow['id']; ?>"
                                        data-url="<?php
                                            echo $data['objUrl']->getCurrent(
                                                'action',
                                                false,
                                                ['action', 'rates','id', $item['id'],
                                                'zid', $crow['id']]); ?>">
                                    <?php echo $crow['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php elseif (!empty($data['zones'])): ?>
                            <?php foreach ($data['zones'] as $zrow): ?>
                                <option value="<?php echo $zrow['id']; ?>"
                                        data-url="<?php
                                            echo $data['objUrl']->getCurrent(
                                                'action',
                                                false,
                                                ['action', 'rates', 'id', $item['id'],
                                                 'zid', $zrow['id']]); ?>">
                                    <?php echo $zrow['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
                <td>
                    <a
                        href="#"
                        data-url="<?php
                            echo $data['objUrl']->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'active', 'id', $item['id']]);
                        ?>"
                        class="click_replace">
                        <?php echo $item['active'] == 1 ? 'Yes' : 'No'; ?>
                    </a>
                </td>
                <td>
                    <a
                        href="#"
                        data-url="<?php
                            echo $data['objUrl']->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'default', 'id', $item['id']]);
                        ?>"
                        data-group="clickDefault<?php echo $item['local']; ?>"
                        data-value="<?php echo $item['default']; ?>"
                        class="click_yes_no_single">
                        <?php echo $item['default'] == 1 ? 'Yes' : 'No'; ?>
                    </a>
                </td>
                <td>
                    <a
                        href="#"
                        data-url="<?php
                            echo $data['objUrl']->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'duplicate', 'id', $item['id']]);
                        ?>"
                        class="click_call_reload">
                        Duplicate
                    </a>
                </td>
                <td>
                    <a
                        href="#"
                        data-url="<?php
                            echo $data['objUrl']->getCurrent(
                                ['action', 'id'],
                                false,
                                ['action', 'remove', 'id', $item['id']]);
                        ?>"
                        class="click_add_row_confirm"
                        data-span="7">
                        Remove
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>There are currently no records.</p>
<?php endif; ?>