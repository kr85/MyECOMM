<?php

use MyECOMM\Business;
use MyECOMM\Country;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Helper;

// Get business information
$objBusiness = new Business();
$business = $objBusiness->getOne(Business::BUSINESS_ID);

// Get countries
$objCountry = new Country();
$countries = $objCountry->getCountries();

if (!empty($business)) {

    $objForm = new Form();
    $objValidation = new Validation($objForm);

    if ($objForm->isPost('name')) {
        $objValidation->expected = [
            'name',
            'address',
            'country',
            'telephone',
            'email',
            'website',
            'tax_rate',
            'tax_number'
        ];

        $objValidation->required = [
            'name',
            'address',
            'country',
            'telephone',
            'email',
            'tax_rate'
        ];

        $objValidation->special = [
            'email' => 'email'
        ];

        $variables = $objForm->getPostArray($objValidation->expected);

        if ($objValidation->isValid()) {
            if ($objBusiness->update($variables, Business::BUSINESS_ID)) {
                $objValidation->addToSuccess('updated_success');
            } else {
                $objValidation->addToErrors('updated_failed');
            }
        }
    }

    require_once('_header.php'); ?>

<div class="business-edit">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="business">
                <a href="/panel/business" title="Go to Business">Business</a>
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
        <h1>Business :: Edit</h1>
    </div>
    <form action="" method="POST">
        <?php echo $objValidation->validate('updated_success'); ?>
        <?php echo $objValidation->validate('updated_failed'); ?>
        <fieldset>
            <legend>Edit Business Information</legend>
            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label for="name">Name: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="<?php echo $objForm->stickyText('name', $business['name']); ?>"
                                />
                            <?php echo $objValidation->validate('name'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="address">Address: <em>*</em></label>
                        <div class="input-box">
                            <textarea
                            name="address"
                            id="address"
                            ><?php
                            echo $objForm->stickyText('address', $business['address']);
                            ?></textarea>
                                <?php echo $objValidation->validate('address'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="country">Country: </label>
                        <?php echo $objForm->getCountriesSelect($business['country'], 'country', true); ?>
                        <?php echo $objValidation->validate('country'); ?>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="telephone">Phone: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="telephone"
                                id="telephone"
                                value="<?php echo $objForm->stickyText('telephone', $business['telephone']); ?>"
                                />
                            <?php echo $objValidation->validate('telephone'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="email">Email Address: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="<?php echo $objForm->stickyText('email', $business['email']); ?>"
                                />
                            <?php echo $objValidation->validate('email'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="website">Website: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="website"
                                id="website"
                                value="<?php echo $objForm->stickyText('website', $business['website']); ?>"
                                />
                            <?php echo $objValidation->validate('website'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="tax_rate">Tax Rate: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="tax_rate"
                                id="tax_rate"
                                value="<?php echo $objForm->stickyText('tax_rate', $business['tax_rate']); ?>"
                                />
                            <?php echo $objValidation->validate('tax_rate'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="tax_number">Tax Number: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="tax_number"
                                id="tax_number"
                                value="<?php echo $objForm->stickyText('tax_number', $business['tax_number']); ?>"
                                />
                            <?php echo $objValidation->validate('tax_number'); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </fieldset>
        <div class="buttons-set">
            <p class="required">* Required Fields</p>
            <a
                href="javascript:history.go(-1)"
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
?>
