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

// Log In form
if ($objForm->isPost('login_email')) {
    if ($objUser->isUser(
        $objForm->getPost('login_email'),
        $objForm->getPost('login_password')
    )
    ) {
        Login::loginFront(
            $objUser->id,
            $this->objUrl->href($this->objUrl->get(Login::$referrer))
        );
    } else {
        $objValidation->addToErrors('login');
    }
}

require_once('_header.php');
?>

<div class="main">
    <div class="page-title">
        <h1>Login or Create an Account</h1>
    </div>
    <div class="account-login">
        <form action="" method="POST" class="form-valid">
            <div class="row-1">
                <div class="col-1">
                    <div class="content">
                        <h2>New Customers</h2>
                        <p>
                            By creating an account with our store, you will be able to
                            move through the checkout process faster, store multiple
                            shipping addresses, view and track your orders in your
                            account and more.
                        </p>
                    </div>
                </div>
                <div class="col-2">
                    <div class="content">
                        <h2>Registered Customers</h2>
                        <p>If you have an account with us, please log in.</p>
                        <div class="form-list">
                            <?php echo $objValidation->validate('login'); ?>
                            <ul>
                                <li class="login-email">
                                    <label for="login_email">Email address: <em>*</em></label>
                                    <input
                                        type="email"
                                        name="login_email"
                                        id="login_email"
                                        class="login-input-field input"
                                        value="<?php echo $objForm->stickyText('login_email'); ?>"
                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                        placeholder="your@email.com"
                                        />
                                </li>
                                <li class="login-passwd">
                                    <label for="login_password">Password: <em>*</em></label>
                                    <input
                                        type="password"
                                        name="login_password"
                                        id="login_password"
                                        class="login-input-field input"
                                        value=""
                                        placeholder="Your password"
                                        />
                                </li>
                            </ul>
                        </div>
                        <p class="required">* Required Fields</p>
                    </div>
                </div>
            </div>
            <div class="row-2">
                <div class="col-1">
                    <div class="buttons-set">
                        <a class="login-btn right" href="<?php echo $this->objUrl->href('register'); ?>">
                            <span>Create an Account</span>
                        </a>
                    </div>
                </div>
                <div class="col-2">
                    <div class="buttons-set">
                        <a
                            href="<?php echo $this->objUrl->href('password-remind'); ?>"
                            class="left"
                        >
                            Forgot Your Password?
                        </a>
                        <label for="btn_login" class="login-btn right">
                            <input
                                type="submit"
                                id="btn_login"
                                class="login-btn-reset"
                                value="Log In"/>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once('_footer.php'); ?>