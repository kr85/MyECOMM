<?php

use MyECOMM\Login;
use MyECOMM\Helper;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\User;

// Check if user is logged in
if (Login::isLogged(Login::$loginFront)) {
    Helper::redirect(Login::$dashboardFront);
}

$objForm = new Form();
$objValidation = new Validation($objForm);
$objUser = new User($this->objUrl);


// Sign Up form
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
        'email',
        'password',
        'confirm_password'
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
        'email',
        'password',
        'confirm_password'
    ];

    // Special validation field
    $objValidation->special = [
        'email' => 'email'
    ];

    // Fields that should not be processed after validation
    $objValidation->postRemove = [
        'confirm_password'
    ];

    // Format (hash) password after post
    $objValidation->postFormat = [
        'password' => 'password'
    ];

    // Check if passwords match
    $password_1 = $objForm->getPost('password');
    $password_2 = $objForm->getPost('confirm_password');

    if (!empty($password_1) && !empty($password_2) && $password_1 != $password_2) {
        $objValidation->addToErrors('password_mismatch');
    }

    // Check if email already exist
    $email = $objForm->getPost('email');
    $user = $objUser->getByEmail($email);

    if (!empty($user)) {
        if ($user['active'] != 1) {
            $emailInactive = '<a href="" id="email_inactive"';
            $emailInactive .= ' data-id="';
            $emailInactive .= $user['id'];
            $emailInactive .= '">Email address is already taken.';
            $emailInactive .= ' Resend activation email.</a>';
            $objValidation->messages['email_inactive'] = $emailInactive;
            $objValidation->addToErrors('email_inactive');
        } else {
            $objValidation->addToErrors('email_duplicate');
        }
    }

    // Check if validation is valid
    if ($objValidation->isValid()) {

        // Add hash for activation account
        $objValidation->post['hash'] = mt_rand().date('YmdHis').mt_rand();

        // Add registration date
        $objValidation->post['date'] = Helper::setDate();

        if ($objUser->addUser(
            $objValidation->post,
            $objForm->getPost('password')
        )
        ) {
            Helper::redirect($this->objUrl->href('registered'));
        } else {
            Helper::redirect($this->objUrl->href('registered-failed'));
        }
    }
}
require_once('_header.php');
?>

<div class="main">
    <div class="page-title">
        <h1>Create an Account</h1>
    </div>
    <div class="account-create">
        <form action="" method="POST" class="form-valid">
            <!-- Avoid remember me for sign up form -->
            <div class="dn">
                <input type="email" name="email"/>
                <input type="password" name="password"/>
            </div>
            <div class="row-1">
                <fieldset>
                    <legend>Personal Information</legend>
                    <ul class="form-list">
                        <li class="fields">
                            <div class="customer-name">
                                <div class="field field-two first-name">
                                    <label for="first_name" class="">First Name: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objValidation->validate('first_name'); ?>
                                        <input
                                            type="text"
                                            name="first_name"
                                            id="first_name"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('first_name'); ?>"
                                            required="required"
                                            pattern="^([ \u00c0-\u01ff\p{L}'\-]){2,50}$"
                                            title="Please enter your first name."
                                        />
                                    </div>
                                </div>
                                <div class="field field-two last-name">
                                    <label for="last_name">Last Name: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objValidation->validate('last_name'); ?>
                                        <input
                                            type="text"
                                            name="last_name"
                                            id="last_name"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('last_name'); ?>"
                                            required="required"
                                            pattern="^([ \u00c0-\u01ff\p{L}'\-]){2,50}$"
                                            title="Please enter your last name."
                                        />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field field-one address">
                                <label for="address_1">Address 1: <em>*</em></label>
                                <div class="input-box">
                                    <?php echo $objValidation->validate('address_1'); ?>
                                    <input
                                        type="text"
                                        name="address_1"
                                        id="address_1"
                                        class="input"
                                        value="<?php echo $objForm->stickyText('address_1'); ?>"
                                        required="required"
                                        title="Please enter the first line of your address."
                                    />
                                </div>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field field-one address">
                                <label for="address_2">Address 2: </label>
                                <div class="input-box">
                                    <?php echo $objValidation->validate('address_2'); ?>
                                    <input
                                        type="text"
                                        name="address_2"
                                        id="address_2"
                                        class=""
                                        value="<?php echo $objForm->stickyText('address_2'); ?>"
                                        title="Please enter the second line of your address."
                                    />
                                </div>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field field-three city">
                                <label for="city">City: <em>*</em></label>
                                <div class="input-box">
                                    <?php echo $objValidation->validate('city'); ?>
                                    <input
                                        type="text"
                                        name="city"
                                        id="city"
                                        class="input"
                                        value="<?php echo $objForm->stickyText('city'); ?>"
                                        required="required"
                                        title="Please enter your city."
                                    />
                                </div>
                            </div>
                            <div class="field field-three state">
                                <label for="state">State/Province: <em>*</em></label>
                                <div class="input-box">
                                    <?php echo $objValidation->validate('state'); ?>
                                    <?php echo $objForm->getCountryStatesSelect(
                                        230,
                                        null,
                                        'states',
                                        false,
                                        'create-account-state state-select'
                                    ); ?>
                                    <input
                                        type="text"
                                        name="state"
                                        id="state"
                                        class="input state-input"
                                        value="<?php echo $objForm->stickyText('state'); ?>"
                                        required="required"
                                        title="Please enter your state."
                                        style="display: none;"
                                    />
                                </div>
                            </div>
                            <div class="field field-three zipcode">
                                <label for="zip_code">ZIP Code: <em>*</em></label>
                                <div class="input-box">
                                    <?php echo $objValidation->validate('zip_code'); ?>
                                    <input
                                        type="text"
                                        name="zip_code"
                                        id="zip_code"
                                        class="input"
                                        value="<?php echo $objForm->stickyText('zip_code'); ?>"
                                        required="required"
                                        title="Please enter your zipcode."
                                    />
                                </div>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field field-one">
                                <label for="country">Country: <em>*</em></label>
                                <div class="input-box">
                                    <?php echo $objValidation->validate('country'); ?>
                                    <?php echo $objForm->getCountriesSelect(
                                        230,
                                        'country',
                                        false,
                                        'create-account-country'
                                    ); ?>
                                </div>
                            </div>
                        </li>
                        <li class="fields">
                            <div class="field field-one email">
                                <label for="email">Email Address: <em>*</em></label>
                                <div class="input-box">
                                    <?php echo $objValidation->validate('email'); ?>
                                    <?php echo $objValidation->validate('email_duplicate'); ?>
                                    <?php echo $objValidation->validate('email_inactive'); ?>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="input"
                                        value="<?php echo $objForm->stickyText('email'); ?>"
                                        required="required"
                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                        autocomplete="off"
                                        title="Please enter a valid email address."
                                    />
                                </div>
                            </div>
                        </li>
                    </ul>
                </fieldset>
            </div>
            <div class="row-2">
                <fieldset>
                    <legend>Login Information</legend>
                    <ul class="form-list">
                        <li class="fields">
                            <div class="login-info">
                                <div class="field field-two passwd">
                                    <label for="password">Password: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objValidation->validate('password'); ?>
                                        <?php echo $objValidation->validate('password_mismatch'); ?>
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            class="input"
                                            required="required"
                                            autocomplete="off"
                                            pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                            title="Must contain at least one
                                            UpperCase letter, LowerCase letter,
                                            Number/Special Character and be minimum of 8 characters."
                                            maxlength="16"
                                        />
                                    </div>
                                </div>
                                <div class="field field-two passwd-conf">
                                    <label for="confirm_password">Password Confirmation: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objValidation->validate('confirm_password'); ?>
                                        <input
                                            type="password"
                                            name="confirm_password"
                                            id="confirm_password"
                                            class="input"
                                            required="required"
                                            autocomplete="off"
                                            pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                            title="Must contain at least one
                                            UpperCase letter, LowerCase letter,
                                            Number/Special Character and be minimum of 8 characters."
                                            maxlength="16"
                                        />
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </fieldset>
            </div>
            <div class="row-3">
                <div class="buttons-set">
                    <p class="required">* Required Fields</p>
                    <a
                        href="javascript:history.go(-1)"
                        class="left back-btn">
                        <small>« </small>Back
                    </a>
                    <label for="btn_login" class="login-btn right">
                        <input
                            type="submit"
                            id="btn_login"
                            class="login-btn-reset"
                            value="Submit"/>
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once('_footer.php'); ?>