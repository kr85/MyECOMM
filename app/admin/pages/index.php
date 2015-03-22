<?php

use MyECOMM\Login;
use MyECOMM\Helper;
use MyECOMM\Form;
use MyECOMM\Validation;

// Check if the user is logged in and redirect if true
if (Login::isLogged(Login::$loginAdmin)) {
    Helper::redirect(Login::$dashboardAdmin);
}

$objForm = new Form();
$objValidation = new Validation($objForm);

if ($objForm->isPost('login_email')) {
    if ($this->objAdmin->isUser(
        $objForm->getPost('login_email'),
        $objForm->getPost('login_password')
    )
    ) {
        Login::loginAdmin(
            $this->objAdmin->id,
            $this->objUrl->href(
                $this->objUrl->get(Login::$referrer)
            )
        );
    } else {
        $objValidation->addToErrors('login');
    }
}
require_once('_header.php');

?>

<div class="main login">
    <div class="form-wrapper">
        <div class="page-title">
            <h1>Administrator Log In</h1>
        </div>
        <form action="" method="POST">
            <fieldset>
                <legend>Log In Here</legend>
                <?php echo $objValidation->validate('login'); ?>
                <ul class="form-list">
                    <li class="fields">
                        <div class="field field-one email">
                            <label for="login_email">Email Address: <em>*</em></label>
                            <div class="input-box">
                                <input
                                    type="email"
                                    name="login_email"
                                    id="login_email"
                                    class="input"
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                    title="Please enter your email address."
                                    />
                        </div>
                    </li>
                    <li class="fields">
                        <div class="field field-one password">
                            <label for="login_password">Password: <em>*</em></label>
                            <div class="input-box">
                                <input
                                    type="password"
                                    name="login_password"
                                    id="login_password"
                                    class="input"
                                    autocomplete="off"
                                    title="Must contain at least one UpperCase letter, LowerCase letter, Number/Special Character and be minimum of 8 characters."
                                    maxlength="16"
                                    />
                            </div>
                        </div>
                    </li>
                </ul>
            </fieldset>
            <div class="buttons-set">
                <p class="required">* Required Fields</p>
                <label for="btn_submit" class="login-btn right">
                    <input
                        type="submit"
                        id="btn_submit"
                        class="login-btn-reset"
                        value="Log In"/>
                </label>
            </div>
        </form>
    </div>
</div>

<?php require_once('_footer.php'); ?>