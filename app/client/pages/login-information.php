<?php

use MyECOMM\Login;
use MyECOMM\Plugin;
use MyECOMM\Catalog;
use MyECOMM\User;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Form;
use MyECOMM\Validation;

// Restrict access only for logged in users
Login::restrictFront($this->objUrl);

$objUser = new User();
$user = $objUser->getUser(Session::getSession(Login::$loginFront));

if (!empty($user)):
    $objCatalog = new Catalog();
    $objForm = new Form();
    $objValidation = new Validation($objForm);

    if ($objForm->isPost('email')):
        $objValidation->expected = [
            'email',
            'current_password',
            'new_password',
            'confirm_new_password'
        ];

        $objValidation->required = [
            'email',
            'current_password',
            'new_password',
            'confirm_new_password'
        ];

        $objValidation->special = [
            'email' => 'email'
        ];

        $objValidation->postRemove = [
            'current_password',
            'confirm_new_password'
        ];

        $objValidation->postFormat = [
            'password' => 'password'
        ];

        $currentPassword = $objForm->getPost('current_password');
        if ($user['password'] != Login::stringToHash($currentPassword)):
            $objValidation->addToErrors('current_password_mismatch');
        endif;

        $password_1 = $objForm->getPost('new_password');
        $password_2 = $objForm->getPost('confirm_new_password');

        if (!empty($password_1) && !empty($password_2) && $password_1 != $password_2) {
            $objValidation->addToErrors('password_mismatch');
        }

        $newEmail = $objForm->getPost('email');
        $result = $objUser->getByEmail($newEmail);
        if (!empty($result) && $user['id'] != $result['id']):
            $objValidation->addToErrors('email_duplicate');
        endif;

        $postArray = $objForm->getPostArray();

        if ($objValidation->isValid()):
            $array = [
                'email' => $postArray['email'],
                'password'  => Login::stringToHash($postArray['new_password'])
            ];
            if ($objUser->update($array, $user['id'])):
                $objValidation->addToSuccess('update_success');
            else:
                $objValidation->addToErrors('update_fail');
            endif;
        else:
            $objValidation->addToErrors('update_fail');
        endif;
    endif;

    require_once('_header.php'); ?>

    <div class="main pad-bottom">
        <div class="col-main login-information">
            <div class="page-title">
                <h1>Edit Login Information</h1>
            </div>
            <div class="form-wrapper">
                <?php echo $objValidation->validate('update_success'); ?>
                <?php echo $objValidation->validate('update_fail'); ?>
                <form action="" method="POST" class="form-login-information">
                    <!-- Avoid remember me for sign up form -->
                    <div class="dn">
                        <input type="email" name="email"/>
                        <input type="password" name="password"/>
                    </div>
                    <fieldset>
                        <legend>Login Information</legend>
                        <ul class="form-list">
                            <li class="fields">
                                <div class="field field-one email">
                                    <label for="email">Email Address: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('email', $user['email']); ?>"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            autocomplete="off"
                                            title="Please enter a valid email address."
                                            />
                                        <?php echo $objValidation->validate('email'); ?>
                                        <?php echo $objValidation->validate('email_duplicate'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one password">
                                    <label for="current_password">Current Password: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="password"
                                            name="current_password"
                                            id="current_password"
                                            class="input"
                                            autocomplete="off"
                                            pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                            title="Must contain at least one UpperCase letter, LowerCase letter, Number/Special Character and be minimum of 8 characters."
                                            maxlength="16"
                                            />
                                        <?php echo $objValidation->validate('current_password_mismatch'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="login-info">
                                    <div class="field field-two passwd">
                                        <label for="new_password">New Password: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="password"
                                                name="new_password"
                                                id="new_password"
                                                class="input"
                                                autocomplete="off"
                                                pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                                title="Must contain at least one UpperCase letter, LowerCase letter, Number/Special Character and be minimum of 8 characters."
                                                maxlength="16"
                                                />
                                            <?php echo $objValidation->validate('new_password'); ?>
                                            <?php echo $objValidation->validate('password_mismatch'); ?>
                                        </div>
                                    </div>
                                    <div class="field field-two passwd-conf">
                                        <label for="confirm_new_password">New Password Confirmation: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="password"
                                                name="confirm_new_password"
                                                id="confirm_new_password"
                                                class="input"
                                                autocomplete="off"
                                                pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                                title="Must contain at least one UpperCase letter, LowerCase letter, Number/Special Character and be minimum of 8 characters."
                                                maxlength="16"
                                                />
                                            <?php echo $objValidation->validate('confirm_new_password'); ?>
                                            <?php echo $objValidation->validate('password_mismatch'); ?>
                                        </div>
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
                                value="Save"/>
                        </label>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-right sidebar">
            <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
                'objUrl'        => $this->objUrl,
                'objCurrency'   => $this->objCurrency,
                'objNavigation' => $this->objNavigation,
                'objCatalog'    => $objCatalog,
                'listing'       => 'category',
                'id'            => 0,
                'productId'     => 0,
                'dashboard'     => true
            ]); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php require_once('_footer.php');
else:
    Helper::redirect($this->objUrl->href('error'));
endif; ?>