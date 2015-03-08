<?php

use MyECOMM\Catalog;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Helper;

$id = $this->objUrl->get('id');

if (!empty($id)) {
    $objCatalog = new Catalog();
    $section = $objCatalog->getSection($id);

    if (!empty($section)) {
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

            $name = $objForm->getPost('name');
            $identity = Helper::cleanString($objForm->getPost('identity'));

            // Check for duplicate section name
            if ($objCatalog->duplicateSection($name, $id)) {
                if ($section['id'] != $id) {
                    $objValidation->addToErrors('name_duplicate');
                }
            }

            // Check for duplicate section identity
            if ($objCatalog->isDuplicateSection($identity, $id)) {
                if ($section['id'] != $id) {
                    $objValidation->addToErrors('duplicate_identity');
                }
            }

            if ($objValidation->isValid()) {
                $objValidation->post['identity'] = $identity;

                if ($objCatalog->updateSection($objValidation->post, $id)) {
                    Helper::redirect(
                        $this->objUrl->getCurrent(['action', 'id']).'/action/edited');
                } else {
                    Helper::redirect(
                        $this->objUrl->getCurrent(['action', 'id']). '/action/edited-failed'
                    );
                }
            }
        }

        require_once('_header.php');
        ?>
        <h1>Sections :: Edit</h1>

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
                               value="<?php echo $objForm->stickyText(
                                   'name',
                                   $section['name']
                               ); ?>" class="fld"/>
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
                                   'identity',
                                   $section['identity']
                               ); ?>" class="fld"/>
                    </td>
                </tr>
                <tr>
                    <th><label for="meta_title">Meta Title: *</label></th>
                    <td>
                        <?php echo $objValidation->validate('meta_title'); ?>
                        <input type="text" name="meta_title" id="meta_title"
                               value="<?php echo $objForm->stickyText(
                                   'meta_title',
                                   $section['meta_title']
                               ); ?>" class="fld"/>
                    </td>
                </tr>
                <tr>
                    <th><label for="meta_description">Meta Description: *</label></th>
                    <td>
                        <?php echo $objValidation->validate('meta_description'); ?>
                        <textarea name="meta_description" id="meta_description"
                                  cols="" rows="" class="tar_fixed"><?php
                                echo $objForm->stickyText(
                                    'meta_description',
                                    $section['meta_description']
                                );
                            ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <label for="btn" class="sbm sbm_blue fl_l">
                            <input type="submit" id="btn" class="btn" value="Update"/>
                        </label>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        require_once('_footer.php');
    }
}
?>