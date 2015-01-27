<?php

    $objForm = new Form();
    $objValidation = new Validation($objForm);

    if ($objForm->isPost('name')) {

        $objValidation->expected = ['name'];
        $objValidation->required = ['name'];

        $objCatalog = new Catalog();
        $name = $objForm->getPost('name');

        if ($objCatalog->duplicateCategory($name)) {
            $objValidation->addToErrors('name_duplicate');
        }

        if ($objValidation->isValid()) {
            if ($objCatalog->addCategory($name)) {
                Helper::redirect('/admin' . Url::getCurrentUrl([
                            'action',
                            'id']
                    ) . '&action=added'
                );
            } else {
                Helper::redirect('/admin' . Url::getCurrentUrl([
                            'action',
                            'id']
                    ) . '&action=added-failed'
                );
            }
        }
    }

    require_once('templates/_header.php');
?>

    <h1>Categories :: Add</h1>

    <form action="" method="POST">
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
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
                <th>&nbsp;</th>
                <td>
                    <label for="btn" class="sbm sbm_blue fl_l">
                        <input type="submit" id="btn" class="btn" value="Add"/>
                    </label>
                </td>
            </tr>
        </table>
    </form>

<?php require_once('templates/_footer.php'); ?>