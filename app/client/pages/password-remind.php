<?php

use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Helper;
use MyECOMM\User;

$objForm = new Form();
$objValidation = new Validation($objForm);

if ($objForm->isPost('email')) {

    $objValidation->expected = ['email'];
    $objValidation->required = ['email'];
    $objValidation->special = [
        'email' => 'email'
    ];

    if ($objValidation->isValid()) {
        $email = $objForm->getPost('email');
        $objUser = new User();
        $user = $objUser->getByEmail($email);
        $time = Helper::setDate(null, '+1 hour');
        $hash = Helper::getResetPasswordHash($user['id'], $time);
        $objUser->resetPassword($user['email'], $hash, $time);
        $objValidation->addToSuccess('remind_success');
    } else {
        $objValidation->addToErrors('remind_fail');
    }
}
require_once('_header.php') ?>

<div class="main pad-bottom">
    <div class="passwd-remind">
        <div class="page-title">
            <h1>Forgot Your Password?</h1>
        </div>
        <form action="" method="post">
            <?php echo $objValidation->validate('remind_success'); ?>
            <?php echo $objValidation->validate('remind_fail'); ?>
            <fieldset>
                <legend>Retrieve Your Password Here</legend>
                <p>
                    Please enter your email address below.
                    You will receive a link to reset your password.
                </p>
                <ul class="form-list">
                    <li class="fields">
                        <div class="field field-one email">
                            <label for="email">
                                Email Address <em>*</em>
                            </label>
                            <div class="input-box">
                                <input type="text" id="email" name="email"/>
                                <?php echo $objValidation->validate('email'); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </fieldset>
            <div class="buttons-set">
                <p class="required">* Required Fields</p>
                <a
                    href="<?php echo $this->objUrl->href('login'); ?>"
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
        </form>
    </div>
</div>

<?php require_once('_footer.php') ?>