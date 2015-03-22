<?php

use MyECOMM\Catalog;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Helper;

$id = $this->objUrl->get('id');

if (!Helper::isEmpty($id)) {
    $objCatalog = new Catalog();
    $section = $objCatalog->getSection($id);

    if (!Helper::isEmpty($section)) {
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
                    $objValidation->addToSuccess('updated_success');
                } else {
                    $objValidation->addToErrors('updated_failed');
                }
            }
        }

        require_once('_header.php'); ?>

<div class="section-edit">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="sections">
                <a href="/panel/sections" title="Go to Sections">Sections</a>
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
        <h1>Sections :: Edit</h1>
    </div>
    <form action="" method="POST">
        <?php echo $objValidation->validate('updated_success'); ?>
        <?php echo $objValidation->validate('updated_failed'); ?>
        <fieldset>
            <legend>Add New Section</legend>
            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label for="name">Name: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="<?php echo $objForm->stickyText('name', $section['name']); ?>"
                            />
                            <?php
                            echo $objValidation->validate('name');
                            echo $objValidation->validate('name_duplicate');
                            ?>
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
                                value="<?php echo $objForm->stickyText('identity', $section['identity']); ?>"
                            />
                            <?php
                            echo $objValidation->validate('identity');
                            echo $objValidation->validate('duplicate_identity');
                            ?>
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
                                value="<?php echo $objForm->stickyText('meta_title', $section['meta_title']); ?>"
                            />
                            <?php echo $objValidation->validate('identity'); ?>
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
                        echo $objForm->stickyText('meta_description', $section['meta_description']);
                        ?></textarea>
                            <?php echo $objValidation->validate('meta_description'); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </fieldset>
        <div class="buttons-set">
            <p class="required">* Required Fields</p>
            <a
                href="/panel/sections"
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