<?php

use MyECOMM\Catalog;
use MyECOMM\Paging;
use MyECOMM\Helper;

$objCatalog = new Catalog();
$sections = $objCatalog->getSection();

$objPaging = new Paging($this->objUrl, $sections, 5);
$rows = $objPaging->getRecords();

require_once('_header.php'); ?>

<h1>Sections</h1>

<p>
    <a href="<?php echo $this->objUrl->getCurrent(['action','id']).'/action/add'; ?>">
        New Section
    </a>
</p>

<?php if (!empty($rows)): ?>

<table class="tbl_repeat">
    <tr>
        <th>Section</th>
        <th class="ta_r col_15">Remove</th>
        <th class="ta_r col_15">Edit</th>
    </tr>
    <?php foreach ($rows as $section): ?>
        <tr>
            <td><?php echo Helper::encodeHTML($section['name']); ?></td>
            <td class="ta_r">
                <a href="<?php echo $this->objUrl->getCurrent([
                            'action',
                            'id'
                        ]).'/action/remove/id/'.$section['id']; ?>">
                    Remove
                </a>
            </td>
            <td class="ta_r">
                <a href="<?php echo $this->objUrl->getCurrent([
                            'action',
                            'id'
                        ]).'/action/edit/id/'.$section['id']; ?>">
                    Edit
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php echo $objPaging->getPaging(); ?>

<?php else: ?>
<p>There are currently no sections created.</p>
<?php endif; ?>

<?php require_once('_footer.php'); ?>