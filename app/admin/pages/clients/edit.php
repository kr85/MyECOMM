<?php

use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Helper;
use MyECOMM\User;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objUser = new User();
    $user = $objUser->getUser($id);

    if (!empty($user)) {

        $objForm = new Form();
        $objValidation = new Validation($objForm);

        // Edit form
        if ($objForm->isPost('first_name')) {

            // Expected fields
            $objValidation->expected = [
                'first_name',
                'last_name',

                'address_1',
                'address_2',
                'city',
                'state',
                'zip_code',
                'country',

                'shipping_first_name',
                'shipping_last_name',
                'shipping_address_1',
                'shipping_address_2',
                'shipping_city',
                'shipping_state',
                'shipping_zip_code',
                'shipping_country',
                'shipping_email',

                'email'
            ];

            // Required fields
            $objValidation->required = [
                'first_name',
                'last_name',
                'address_1',
                'city',
                'state',
                'zip_code',
                'country',
                'email'
            ];

            // Special validation field
            $objValidation->special = [
                'email' => 'email'
            ];

            // Get the email from post and user by email
            $email = $objForm->getPost('email');
            $duplicate = $objUser->getByEmail($email);

            // Check if the email already exist
            if (!empty($duplicate) && $duplicate['id'] != $user['id']) {
                $objValidation->addToErrors('email_duplicate');
            }

            // Check if validation was successful
            if ($objValidation->isValid()) {

                if ($objUser->updateUser(
                    $objValidation->post,
                    $user['id']
                )
                ) {
                    $objValidation->addToSuccess('updated_success');
                } else {
                    $objValidation->addToErrors('updated_failed');
                }
            }
        }
        require_once('_header.php'); ?>

<div class="client-edit">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="clients">
                <a href="/panel/clients" title="Go to Clients">Clients</a>
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
        <h1>Clients :: Edit</h1>
    </div>
    <form action="" method="POST">
        <?php echo $objValidation->validate('updated_success'); ?>
        <?php echo $objValidation->validate('updated_failed'); ?>
        <fieldset>
            <legend>Personal Information</legend>
            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label for="first_name">First Name: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="first_name"
                                id="first_name"
                                value="<?php echo $objForm->stickyText('first_name',  $user['first_name']); ?>"
                            />
                            <?php echo $objValidation->validate('first_name'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="last_name">Last Name: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="last_name"
                                id="last_name"
                                value="<?php echo $objForm->stickyText('last_name',  $user['last_name']); ?>"
                                />
                            <?php echo $objValidation->validate('last_name'); ?>
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
                                value="<?php echo $objForm->stickyText('email',  $user['email']); ?>"
                                />
                            <?php echo $objValidation->validate('email'); ?>
                        </div>
                    </div>
                </li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Billing Information</legend>
            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label for="address_1">Address 1: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="address_1"
                                id="address_1"
                                value="<?php echo $objForm->stickyText('address_1',  $user['address_1']); ?>"
                                />
                            <?php echo $objValidation->validate('address_1'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="address_2">Address 2: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="address_2"
                                id="address_2"
                                value="<?php echo $objForm->stickyText('address_2',  $user['address_2']); ?>"
                                />
                            <?php echo $objValidation->validate('address_2'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="city">City: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="city"
                                id="city"
                                value="<?php echo $objForm->stickyText('city',  $user['city']); ?>"
                                />
                            <?php echo $objValidation->validate('city'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="state">State: <em>*</em></label>
                        <div class="input-box">
                            <?php echo $objForm->getCountryStatesSelect('input', $user['country'], $user['state']); ?>
                            <?php echo $objValidation->validate('state'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="zip_code">ZIP Code: <em>*</em></label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="zip_code"
                                id="zip_code"
                                value="<?php echo $objForm->stickyText('zip_code',  $user['zip_code']); ?>"
                                />
                            <?php echo $objValidation->validate('zip_code'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="country">Country: <em>*</em></label>
                        <?php echo $objForm->getCountriesSelect($user['country']); ?>
                        <?php echo $objValidation->validate('country'); ?>
                    </div>
                </li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Shipping Information</legend>
            <ul class="form-list">
                <li class="fields">
                    <div class="field">
                        <label for="shipping_first_name">First Name: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="shipping_first_name"
                                id="shipping_first_name"
                                value="<?php echo $objForm->stickyText('shipping_first_name',  $user['shipping_first_name']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_first_name'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_last_name">Last Name: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="shipping_last_name"
                                id="shipping_last_name"
                                value="<?php echo $objForm->stickyText('shipping_last_name',  $user['shipping_last_name']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_last_name'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_email">Email Address: </label>
                        <div class="input-box">
                            <input
                                type="email"
                                name="shipping_email"
                                id="shipping_email"
                                value="<?php echo $objForm->stickyText('shipping_email',  $user['shipping_email']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_email'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_address_1">Address 1: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="shipping_address_1"
                                id="shipping_address_1"
                                value="<?php echo $objForm->stickyText('shipping_address_1',  $user['shipping_address_1']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_address_1'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_address_2">Address 2: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="shipping_address_2"
                                id="shipping_address_2"
                                value="<?php echo $objForm->stickyText('shipping_address_2',  $user['shipping_address_2']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_address_2'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_city">City: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="shipping_city"
                                id="shipping_city"
                                value="<?php echo $objForm->stickyText('shipping_city',  $user['shipping_city']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_city'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_state">State: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="shipping_state"
                                id="shipping_state"
                                value="<?php echo $objForm->stickyText('shipping_state',  $user['shipping_state']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_state'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_zip_code">ZIP Code: </label>
                        <div class="input-box">
                            <input
                                type="text"
                                name="shipping_zip_code"
                                id="shipping_zip_code"
                                value="<?php echo $objForm->stickyText('shipping_zip_code',  $user['shipping_zip_code']); ?>"
                                />
                            <?php echo $objValidation->validate('shipping_zip_code'); ?>
                        </div>
                    </div>
                </li>
                <li class="fields">
                    <div class="field">
                        <label for="shipping_country">Country: </label>
                        <?php echo $objForm->getCountriesSelect($user['shipping_country'], 'shipping_country', true); ?>
                        <?php echo $objValidation->validate('shipping_country'); ?>
                    </div>
                </li>
            </ul>
        </fieldset>
        <div class="buttons-set">
            <p class="required">* Required Fields</p>
            <a
                href="/panel/clients"
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
