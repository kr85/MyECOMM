<?php

use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Catalog;
use MyECOMM\Helper;

$objForm = new Form();
$objValidation = new Validation($objForm);

if ($objForm->isPost('name')) {

    $objValidation->expected = [
        'name',
        'identity',
        'meta_title',
        'meta_description'
    ];

    $objValidation->required = [
        'name',
        'identity',
        'meta_title',
        'meta_description'
    ];

    $objCatalog = new Catalog();
    $name = $objForm->getPost('name');
    $identity = Helper::cleanString($objForm->getPost('identity'));

    // Check for duplicate name
    if ($objCatalog->duplicateSection($name)) {
        $objValidation->addToErrors('name_duplicate');
    }

    // Check for duplicate identity
    if ($objCatalog->isDuplicateSection($identity)) {
        $objValidation->addToErrors('duplicate_identity');
    }

    if ($objValidation->isValid()) {
        $objValidation->post['identity'] = $identity;

        if ($objCatalog->addSection($objValidation->post)) {
            Helper::redirect(
                $this->objUrl->getCurrent(
                    ['action', 'id'], false, ['action', 'added'])
            );
        } else {
            Helper::redirect(
                $this->objUrl->getCurrent(
                    ['action', 'id'], false, ['action', 'added-failed'])
            );
        }
    }
}

require_once('_header.php');
?>

<h1>Sections :: Add</h1>

<form action="" method="POST">
    <table class="tbl_insert">
        <tr>
            <th><label for="name">Name: *</label></th>
            <td>
                <?php
                    echo $objValidation->validate('name');
                    echo $objValidation->validate('name_duplicate');
                ?>
                <input type="text" name="name" id="name"
                       value="<?php echo $objForm->stickyText('name'); ?>"
                       class="fld"/>
            </td>
        </tr>
        <tr>
            <th><label for="identity">Identity: *</label></th>
            <td>
                <?php
                    echo $objValidation->validate('identity');
                    echo $objValidation->validate('duplicate_identity');
                ?>
                <input type="text" name="identity" id="identity"
                       value="<?php echo $objForm->stickyText(
                           'identity'
                       ); ?>" class="fld"/>
            </td>
        </tr>
        <tr>
            <th><label for="meta_title">Meta Title: *</label></th>
            <td>
                <?php echo $objValidation->validate('meta_title'); ?>
                <input type="text" name="meta_title" id="meta_title"
                       value="<?php echo $objForm->stickyText(
                           'meta_title'
                       ); ?>" class="fld"/>
            </td>
        </tr>
        <tr>
            <th><label for="meta_description">Meta Description: *</label>
            </th>
            <td>
                <?php echo $objValidation->validate('meta_description'); ?>
                <textarea name="meta_description" id="meta_description"
                          cols="" rows="" class="tar_fixed"><?php
                        echo $objForm->stickyText('meta_description');
                    ?></textarea>
            </td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>
                <label for="btn" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn" class="btn" value="Add"/>
                </label>
            </td>
        </tr>
    </table>
</form>

<?php require_once('_footer.php'); ?>