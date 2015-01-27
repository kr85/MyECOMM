<?php

    $id = Url::getParam('id');

    if (!empty($id)) {
        $objCatalog = new Catalog();
        $category = $objCatalog->getCategory($id);

        if (!empty($category)) {
            $objForm = new Form();
            $objValidation = new Validation($objForm);

            if ($objForm->isPost('name')) {
                $objValidation->expected = ['name'];
                $objValidation->required = ['name'];

                $name = $objForm->getPost('name');

                if ($objCatalog->duplicateCategory($name, $id)) {
                    $objValidation->addToErrors('name_duplicate');
                }

                if ($objValidation->isValid()) {
                    if ($objCatalog->updateCategory($name, $id)) {
                        Helper::redirect('/admin' . Url::getCurrentUrl([
                                    'action',
                                    'id']
                            ) . '&action=edited'
                        );
                    } else {
                        Helper::redirect('/admin' . Url::getCurrentUrl([
                                    'action',
                                    'id']
                            ) . '&action=edited-failed'
                        );
                    }
                }
            }

    require_once('templates/_header.php');
?>
            <h1>Categories :: Edit</h1>

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
                                   value="<?php echo $objForm->stickyText(
                                       'name',
                                       $category['name']
                                   ); ?>"
                                   class="fld"/>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <label for="btn" class="sbm sbm_blue fl_l">
                                <input type="submit" id="btn" class="btn"
                                       value="Update"/>
                            </label>
                        </td>
                    </tr>
                </table>
            </form>
<?php
            require_once('templates/_footer.php');
        }
    }
?>