<?php

    $objForm = new Form();
    $objValidation = new Validation($objForm);

    $objCatalog = new Catalog();
    $categories = $objCatalog->getCategories();

    if ($objForm->isPost('name')) {

        $objValidation->expected = [
            'category',
            'name',
            'description',
            'price',
            'weight',
            'identity',
            'meta_title',
            'meta_description',
            'meta_keywords'
        ];

        $objValidation->required = [
            'category',
            'name',
            'description',
            'price',
            'weight',
            'identity',
            'meta_title',
            'meta_description',
            'meta_keywords'
        ];

        if ($objValidation->isValid()) {
            $objValidation->post['identity'] = Helper::cleanString(
                $objValidation->post['identity']
            );

            if ($objCatalog->isDuplicateProduct(
                $objValidation->post['identity']
            )
            ) {
                $objValidation->addToErrors('duplicate_identity');
            } else {
                if ($objCatalog->addProduct($objValidation->post)) {

                    $objUpload = new Upload();

                    if ($objUpload->upload(CATALOG_PATH)) {
                        $objCatalog->updateProduct(
                            [
                                'image' => $objUpload->names[0]
                            ],
                            $objCatalog->id
                        );

                        Helper::redirect(
                            $this->objUrl->getCurrent(
                                ['action', 'id'], false, ['action', 'added']
                            )
                        );
                    } else {
                        Helper::redirect(
                            $this->objUrl->getCurrent(
                                ['action', 'id'], false, ['action', 'added-no-upload']
                            )
                        );
                    }
                } else {
                    Helper::redirect(
                        $this->objUrl->getCurrent(
                            ['action', 'id'], false, ['action', 'added-failed']
                        )
                    );
                }
            }
        }
    }

    require_once('_header.php');
?>

    <h1>Products :: Add</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
            <tr>
                <th><label for="category">Category: *</label></th>
                <td>
                    <?php echo $objValidation->validate('category'); ?>
                    <select name="category" id="category" class="sel">
                        <option value="">Select One&hellip;</option>
                        <?php if (!empty($categories)) { ?>
                            <?php foreach ($categories as $category) { ?>
                                <option value="<?php echo $category['id']; ?>"
                                    <?php echo $objForm->stickySelect(
                                        'category',
                                        $category['id']
                                    ); ?>>
                                    <?php echo Helper::encodeHTML(
                                        $category['name']
                                    ); ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="name">Name: *</label></th>
                <td>
                    <?php echo $objValidation->validate('name'); ?>
                    <input type="text" name="name" id="name"
                           value="<?php echo $objForm->stickyText('name'); ?>"
                           class="fld"/>
                </td>
            </tr>
            <tr>
                <th><label for="description">Description: *</label></th>
                <td>
                    <?php echo $objValidation->validate('description'); ?>
                    <textarea name="description" id="description" cols=""
                              rows=""
                              class="tar_fixed"><?php echo $objForm->stickyText(
                            'description'
                        ); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="price">Price: *</label></th>
                <td>
                    <?php echo $objValidation->validate('price'); ?>
                    <input type="text" name="price" id="price"
                           value="<?php echo $objForm->stickyText('price', '0.00'); ?>"
                           class="fld_price"/>
                </td>
            </tr>
            <tr>
                <th><label for="weight">Weight: *</label></th>
                <td>
                    <?php echo $objValidation->validate('weight'); ?>
                    <input type="text" name="weight" id="weight"
                           value="<?php echo $objForm->stickyText('weight', '0.00'); ?>"
                           class="fld_price"/>
                </td>
            </tr>
            <tr>
                <th><label for="identity">Identity: *</label></th>
                <td>
                    <?php echo $objValidation->validate('identity'); ?>
                    <?php echo $objValidation->validate(
                        'duplicate_identity'
                    ); ?>
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
                            echo $objForm->stickyText(
                                'meta_description'
                            ); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="meta_keywords">Meta Keywords: *</label></th>
                <td>
                    <?php echo $objValidation->validate('meta_keywords'); ?>
                    <textarea name="meta_keywords" id="meta_keywords" cols=""
                              rows="" class="tar_fixed"><?php
                            echo $objForm->stickyText(
                                'meta_keywords'
                            ); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="image">Image:</label></th>
                <td>
                    <?php echo $objValidation->validate('image'); ?>
                    <input type="file" name="image" id="image" size="30"/>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                    <label for="btn" class="sbm sbm_blue fl_l"> <input
                            type="submit" id="btn" class="btn" value="Add"/>
                    </label>
                </td>
            </tr>
        </table>
    </form>

<?php require_once('_footer.php'); ?>