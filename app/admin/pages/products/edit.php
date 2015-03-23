<?php

use MyECOMM\Catalog;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Helper;
use MyECOMM\Upload;
use MyECOMM\Plugin;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objCatalog = new Catalog();
    $product = $objCatalog->getProduct($id);

    if (!empty($product)) {

        $objForm = new Form();
        $objValidation = new Validation($objForm);
        $categories = $objCatalog->getCategories();

        if ($objForm->isPost('section')) {

            $objValidation->expected = [
                'section',
                'category',
                'name',
                'description',
                'price',
                'weight',
                'identity',
                'meta_title',
                'meta_description'
            ];

            $objValidation->required = [
                'section',
                'category',
                'name',
                'description',
                'price',
                'weight',
                'identity',
                'meta_title',
                'meta_description'
            ];

            $identity = Helper::cleanString($objForm->getPost('identity'));

            // Check for duplicate product identity
            if ($objCatalog->isDuplicateProduct(
                $objValidation->post['identity'],
                $id
            )
            ) {
                if ($product['id'] != $id) {
                    $objValidation->addToErrors('duplicate_identity');
                }
            }

            if ($objValidation->isValid()) {
                $objValidation->post['identity'] = $identity;

                if ($objCatalog->updateProduct($objValidation->post, $id)) {

                    $objUpload = new Upload();

                    if ($objUpload->upload(CATALOG_PATH)) {

                        if (is_file(CATALOG_PATH.DS.$product['image'])) {
                            unlink(CATALOG_PATH.DS.$product['image']);
                        }

                        $objCatalog->updateProduct([
                            'image' => $objUpload->names[0]
                        ], $id);

                        $objValidation->addToSuccess('updated_success');
                    } else {
                        $objValidation->addToSuccess('updated_no_upload_success');
                    }
                } else {
                    $objValidation->addToErrors('updated_failed');
                }

            }
        }

        require_once('_header.php'); ?>

<div class="product-edit">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="products">
                <a href="/panel/products" title="Go to Products">Products</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Edit
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Products :: Edit</h1>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <?php echo $objValidation->validate('updated_success'); ?>
        <?php echo $objValidation->validate('updated_no_upload_success'); ?>
        <?php echo $objValidation->validate('updated_failed'); ?>
        <fieldset>
            <legend>Edit Product</legend>
            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label for="section">Section: <em>*</em></label>
                        <div class="input-box">
                            <?php echo $objForm->getSectionsSelect($product['section']); ?>
                            <?php echo $objValidation->validate('section'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="category">Category: <em>*</em></label>
                        <div class="input-box">
                            <div id="categories_select_plugin">
                                <?php echo Plugin::get('admin'.DS.'categories_select', [
                                    'stickySection' => $product['section'],
                                    'stickyCategory' => $product['category']
                                ]); ?>
                            </div>
                            <?php echo $objValidation->validate('category'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="name">Name: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="<?php echo $objForm->stickyText('name', $product['name']); ?>"
                                />
                            <?php echo $objValidation->validate('name'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="description">Description: <em>*</em></label>
                        <div class="input-box">
                <textarea
                    name="description"
                    id="description"
                    ><?php
                    echo $objForm->stickyText('description', $product['description']);
                    ?></textarea>
                            <?php echo $objValidation->validate('description'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="price">Price: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="price"
                                id="price"
                                value="<?php echo $objForm->stickyText('price', $product['price']); ?>"
                                />
                            <?php echo $objValidation->validate('price'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="weight">Weight: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="weight"
                                id="weight"
                                value="<?php echo $objForm->stickyText('weight', $product['weight']); ?>"
                                />
                            <?php echo $objValidation->validate('weight'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="identity">Identity: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="identity"
                                id="identity"
                                value="<?php echo $objForm->stickyText('identity', $product['identity']); ?>"
                                />
                            <?php echo $objValidation->validate('identity'); ?>
                            <?php echo $objValidation->validate('duplicate_identity'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="meta_title">Meta Title: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="meta_title"
                                id="meta_title"
                                value="<?php echo $objForm->stickyText('meta_title', $product['meta_title']); ?>"
                                />
                            <?php echo $objValidation->validate('meta_title'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="meta_description">Meta Description: <em>*</em></label>
                        <div class="input-box">
                <textarea
                    name="meta_description"
                    id="meta_description"
                    ><?php
                    echo $objForm->stickyText('meta_description', $product['meta_description']);
                    ?></textarea>
                            <?php echo $objValidation->validate('meta_description'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="image">Image: </label>
                        <div class="input-box">
                            <input
                                type="file"
                                name="image"
                                id="image"
                                class="image"
                                />
                            <?php echo $objValidation->validate('image'); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </fieldset>
        <div class="buttons-set">
            <p class="required">* Required Fields</p>
            <a
                href="/panel/products"
                class="left back-btn">
                <small>« </small>Back
            </a>
            <label for="btn_submit" class="login-btn right">
                <input
                    type="submit"
                    id="btn_submit"
                    class="login-btn-reset"
                    value="Update"/>
            </label>
        </div>
    </form>
</div>
<?php require_once('_footer.php');
    }
}
?>