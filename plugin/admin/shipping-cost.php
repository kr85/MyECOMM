<?php if (!empty($data['rows'])): ?>
<table class="tbl_repeat">
    <thead>
        <tr>
            <th class="col_1 ta_r">From</th>
            <th class="col_1 ta_r">To</th>
            <th class="ta_r">Cost</th>
            <th class="col_1 ta_r">Remove</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data['rows'] as $item): ?>
        <tr id="row-<?php echo $item['id']; ?>">
            <td class="ta_r">
                <?php echo round($item['weight_from'], 2); ?>
            </td>
            <td class="ta_r">
                <?php echo round($item['weight'], 2); ?>
            </td>
            <td class="ta_r">
                <?php
                    echo Catalog::$currency;
                    echo number_format($item['cost'], 2);
                ?>
            </td>
            <td class="ta_r">
                <a
                    href="#"
                    class="click_add_row_confirm"
                    data-url="<?php
                        echo $data['objUrl']->getCurrent(
                            'call', false, ['call', 'remove', 'rid', $item['id']]
                        ); ?>"
                    data-span="4">
                    Remove
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>There are currently no records associated with this shipping type.</p>
<?php endif; ?>