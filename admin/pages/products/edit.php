<?php

    $id = $this->objUrl->get('id');

    if (!empty($id)) {

        $objCatalog = new Catalog();
        $product = $objCatalog->getProduct($id);

        if (!empty($product)) {

            $objForm = new Form();
            $objValidation = new Validation($objForm);
            $categories = $objCatalog->getCategories();

            if ($objForm->isPost('name')) {

                $objValidation->expected = [
                    'category',
                    'name',
                    'description',
                    'price',
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
                    'identity',
                    'meta_title',
                    'meta_description',
                    'meta_keywords'
                ];

                $identity = Helper::cleanString($objForm->getPost('identity'));

                // Check for duplicate product identity
                if ($objCatalog->isDuplicateProduct(
                    $objValidation->post['identity'], $id)) {
                    if ($product['id'] != $id) {
                        $objValidation->addToErrors('duplicate_identity');
                    }
                }

                if ($objValidation->isValid()) {
                    $objValidation->post['identity'] = $identity;

                    if ($objCatalog->updateProduct($objValidation->post, $id)) {

                        $objUpload = new Upload();

                        if ($objUpload->upload(CATALOG_PATH)) {

                            if (is_file(CATALOG_PATH. DS. $product['image'])) {
                                unlink(CATALOG_PATH. DS. $product['image']);
                            }

                            $objCatalog->updateProduct([
                                'image' => $objUpload->names[0]
                            ], $id);

                            Helper::redirect($this->objUrl->getCurrent([
                                    'action',
                                    'id'
                                ]) . '/action/edited');
                        } else {
                            Helper::redirect($this->objUrl->getCurrent([
                                    'action',
                                    'id'
                                ]) . '/action/edited-no-upload');
                        }
                    } else {
                        Helper::redirect($this->objUrl->getCurrent([
                                'action',
                                'id'
                            ]) . '/action/edited-failed'
                        );
                    }

                }
            }

    require_once('_header.php');
?>
            <h1>Products :: Edit</h1>

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
                                                $category['id'],
                                                $product['category']
                                            );?>>
                                            <?php echo Helper::encodeHTML(
                                                $category['name']);
                                            ?>
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
                                   value="<?php echo $objForm->stickyText(
                                       'name',
                                       $product['name']
                                   ); ?>"
                                   class="fld"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description">Description: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('description'); ?>
                            <textarea name="description" id="description" cols=""
                                      rows="" class="tar_fixed"><?php echo
                                $objForm->stickyText(
                                    'description',
                                    $product['description']
                                ); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="price">Price: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('price'); ?>
                            <input type="text" name="price" id="price"
                                   value="<?php echo $objForm->stickyText(
                                       'price',
                                       $product['price']
                                   ); ?>"
                                   class="fld_price"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="identity">Identity: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('identity'); ?>
                            <?php echo $objValidation->validate('duplicate_identity'); ?>
                            <input type="text" name="identity" id="identity"
                                   value="<?php echo $objForm->stickyText(
                                       'identity',
                                       $product['identity']
                                   ); ?>"
                                   class="fld"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="meta_title">Meta Title: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('meta_title'); ?>
                            <input type="text" name="meta_title" id="meta_title"
                                   value="<?php echo $objForm->stickyText(
                                       'meta_title',
                                       $product['meta_title']
                                   ); ?>"
                                   class="fld"/>
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
                                        $product['meta_description']
                                    ); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="meta_keywords">Meta Keywords: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('meta_keywords'); ?>
                            <textarea name="meta_keywords" id="meta_keywords"
                                      cols="" rows="" class="tar_fixed"><?php
                                    echo $objForm->stickyText(
                                        'meta_keywords',
                                        $product['meta_keywords']
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
                            <label for="btn" class="sbm sbm_blue fl_l">
                                <input type="submit" id="btn" class="btn"
                                       value="Update"/>
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