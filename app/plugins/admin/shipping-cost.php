<?php if (!empty($data['rows'])): ?>
<fieldset>
    <table class="data-table">
        <thead>
            <tr>
                <th class="center" rowspan="1">
                    <span class="nobr">
                        From
                    </span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">
                        To
                    </span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">
                        Cost
                    </span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">
                        Remove
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data['rows'] as $item): ?>
            <tr id="row-<?php echo $item['id']; ?>">
                <td class="center">
                    <?php echo round($item['weight_from'], 2); ?>
                </td>
                <td class="center">
                    <?php echo round($item['weight'], 2); ?>
                </td>
                <td class="center">
                    <?php
                        echo $data['objCurrency']->display(
                            number_format($item['cost'], 2)
                        );
                    ?>
                </td>
                <td class="center">
                    <a
                        href="#"
                        class="click_add_row_confirm btn-remove-2"
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
</fieldset>
<?php else: ?>
<div class="center">
    <p class="empty">
        There are currently <strong>no records</strong> associated with this shipping type.
    </p>
</div>
<?php endif; ?>