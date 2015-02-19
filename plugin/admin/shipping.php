<?php if (!empty($data['rows'])): ?>

    <table class="tbl_repeat">
        <tr>
            <th class="col_1">+</th>
            <th>Type</th>
            <th class="col_1">Rates</th>
            <th class="col_1">Active</th>
            <th class="col_1">Default</th>
            <th class="col_1">Duplicate</th>
            <th class="col_1 ta_r">Remove</th>
        </tr>
        <tbody id="rowsLocal" class="sortRows" data-url="<?php
            echo $data['urlSort'];
        ?>">
            <?php foreach($data['rows'] as $item): ?>

            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <p>There are currently no records.</p>

<?php endif; ?>