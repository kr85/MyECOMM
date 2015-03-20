<?php

use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\User;
use MyECOMM\Helper;
use MyECOMM\Login;

$objForm = new Form();
$objValidation = new Validation($objForm);

$id = $this->objUrl->get('id');
$hash = $this->objUrl->get('token');

$objUser = new User();
$user = $objUser->getUser($id);

$reset = $objUser->getResetPasswordByEmail($user['email']);

$newHash = Helper::getResetPasswordHash($user['id'], $reset['date']);

if ($hash == $newHash) {
    $expiration = $reset['date'];
    $now = Helper::setDate();
    if ($now <= $expiration) {
        if ($objForm->isPost('email')) {

            $objValidation->expected = [
                'email',
                'password',
                'confirm_password'
            ];

            $objValidation->required = [
                'email',
                'password',
                'confirm_password'
            ];

            $objValidation->special = [
                'email' => 'email'
            ];

            $objValidation->postRemove = [
                'confirm_password'
            ];

            $password_1 = $objForm->getPost('password');
            $password_2 = $objForm->getPost('confirm_password');

            if (!empty($password_1) && !empty($password_2) && $password_1 != $password_2) {
                $objValidation->addToErrors('password_mismatch');
            }

            if ($objValidation->isValid()) {
                $result = $objUser->update([
                    'password' => Login::stringToHash($password_1)
                ], $user['id']);
                if ($result) {
                    $objValidation->addToSuccess('reset_success');
                } else {
                    $objValidation->addToErrors('reset_fail');
                }
            } else {
                $objValidation->addToErrors('reset_fail');
            }
        }

        require_once('_header.php') ?>
        <div class="main pad-bottom">
            <div class="passwd-reset">
                <div class="page-title">
                    <h1>Password Reset</h1>
                </div>
                <form action="" method="post">
                    <?php echo $objValidation->validate('reset_success'); ?>
                    <?php echo $objValidation->validate('reset_fail'); ?>
                    <fieldset>
                        <legend>Reset Your Password Here</legend>
                        <p>
                            Please enter your email address and new password below.
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
                            <li class="fields">
                                <div class="field field-two passwd">
                                    <label for="password">Password: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            class="input"
                                            autocomplete="off"
                                            pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                            title="Must contain at least one UpperCase letter, LowerCase letter, Number/Special Character and be minimum of 8 characters."
                                            maxlength="16"
                                            />
                                        <?php echo $objValidation->validate('confirm_password'); ?>
                                        <?php echo $objValidation->validate('password_mismatch'); ?>
                                    </div>
                                </div>
                                <div class="field field-two passwd-conf">
                                    <label for="confirm_password">Password Confirmation: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="password"
                                            name="confirm_password"
                                            id="confirm_password"
                                            class="input"
                                            autocomplete="off"
                                            pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                            title="Must contain at least one UpperCase letter, LowerCase letter, Number/Special Character and be minimum of 8 characters."
                                            maxlength="16"
                                            />
                                        <?php echo $objValidation->validate('confirm_password'); ?>
                                        <?php echo $objValidation->validate('password_mismatch'); ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                    <div class="buttons-set">
                        <p class="required">* Required Fields</p>
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
        <?php require_once('_footer.php');
    } else {
        Helper::redirect($this->objUrl->href('error'));
    }
} else {
    Helper::redirect($this->objUrl->href('error'));
}