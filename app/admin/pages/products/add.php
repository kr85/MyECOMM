<?php

use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Upload;
use MyECOMM\Plugin;

$objForm = new Form();
$objValidation = new Validation($objForm);

$objCatalog = new Catalog();
$categories = $objCatalog->getCategories();

$stickyCategory = 0;
$stickySection = 0;

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

    if ($objForm->getPost('category')) {
        $stickyCategory = $objForm->getPost('category');
    }

    if ($objForm->getPost('section')) {
        $stickySection = $objForm->getPost('section');
    }

    if ($objValidation->isValid()) {
        $objValidation->post['identity'] = Helper::cleanString(
            $objValidation->post['identity']
        );

        if ($objCatalog->isDuplicateProduct(
            $objValidation->post['identity']
        )) {
            $objValidation->addToErrors('duplicate_identity');
        } else {
            if ($objCatalog->addProduct($objValidation->post)) {

                $objUpload = new Upload();

                if ($objUpload->upload(CATALOG_PATH)) {
                    $objCatalog->updateProduct([
                        'image' => $objUpload->names[0]
                    ], $objCatalog->id);

                    $objValidation->addToSuccess('added_success');
                } else {
                    $objValidation->addToSuccess('added_no_upload_success');
                }
            } else {
                $objValidation->addToErrors('added_failed');
            }
        }
    }
}

require_once('_header.php'); ?>

<div class="product-add">
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
                    Add
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Products :: Add</h1>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <?php echo $objValidation->validate('added_success'); ?>
        <?php echo $objValidation->validate('added_no_upload_success'); ?>
        <?php echo $objValidation->validate('added_failed'); ?>
        <fieldset>
            <legend>Add New Product</legend>
            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label for="section">Section: <em>*</em></label>
                        <div class="input-box">
                            <?php echo $objForm->getSectionsSelect(); ?>
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
                                    'stickySection' => $stickySection,
                                    'stickyCategory' => $stickyCategory
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
                                value="<?php echo $objForm->stickyText('name'); ?>"
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
                            echo $objForm->stickyText('description');
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
                                value="<?php echo $objForm->stickyText('price', '0.00'); ?>"
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
                                value="<?php echo $objForm->stickyText('weight', '0.00'); ?>"
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
                                value="<?php echo $objForm->stickyText('identity'); ?>"
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
                                value="<?php echo $objForm->stickyText('meta_title'); ?>"
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
                                echo $objForm->stickyText('meta_description');
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
                    value="Add"/>
            </label>
        </div>
    </form>
</div>

<?php require_once('_footer.php'); ?>