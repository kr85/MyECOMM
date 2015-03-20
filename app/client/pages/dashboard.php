<?php

use MyECOMM\Login;
use MyECOMM\Session;
use MyECOMM\Plugin;
use MyECOMM\Catalog;
use MyECOMM\User;
use MyECOMM\Helper;
use MyECOMM\Country;

// Restrict access only for logged in users
Login::restrictFront($this->objUrl);

$objUser = new User();
$user = $objUser->getUser(Session::getSession(Login::$loginFront));

if (!empty($user)):

    $defaultBillingAddress = false;
    if (!empty($user['address_1']) && !empty($user['city']) &&
        !empty($user['state']) && !empty($user['country'])) {
        $defaultBillingAddress = true;
    }

    $defaultShippingAddress = false;
    if (!empty($user['shipping_address_1']) && !empty($user['shipping_city']) &&
        !empty($user['shipping_state']) && !empty($user['shipping_country'])) {
        $defaultShippingAddress = true;
    }

    $objCountry = new Country();
    $country = $objCountry->getCountry($user['country']);
    $shippingCountry = null;
    if ($user['shipping_country']) {
        $shippingCountry = $objCountry->getCountry($user['shipping_country']);
    }

    $state = $user['state'];
    if (is_numeric($state)) {
        $state = $objCountry->getStateById($state);
        $state = $state['name'];
    }

    $objCatalog = new Catalog();

require_once('_header.php'); ?>

<div class="main pad-bottom">
    <div class="col-main dashboard">
        <div class="page-title">
            <h1>My Dashboard</h1>
        </div>
        <div class="welcome-msg">
            <p class="hello">
                <strong>
                    Hello,
                    <?php echo $user['first_name'].' '.$user['last_name']; ?>
                </strong>
            </p>
            <p>
                From your Account Dashboard you have the ability to view a
                snapshot of your recent account activity and update your account
                information. Select a link below to view or edit information.
            </p>
        </div>
        <div class="box-account box-info">
            <div class="box-head">
                <h2>Account Information</h2>
            </div>
            <div class="col-2-set">
                <div class="col-1">
                    <div class="box">
                        <div class="box-title">
                            <h3>Contact Information</h3>
                        </div>
                        <div class="box-content">
                            <p>
                                <?php echo $user['first_name'].' '.$user['last_name']; ?><br/>
                                <?php echo $user['email']; ?><br/>
                                <a href="<?php echo $this->objUrl->href('login-information'); ?>">
                                    Change Password
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-2-set">
                <div class="box">
                    <div class="box-title">
                        <h3>Address Book</h3>
                    </div>
                    <div class="box-content">
                        <div class="col-1">
                            <h4>Default Billing Address</h4>
                            <address>
                                <?php if ($defaultBillingAddress): ?>
                                    <?php echo $user['address_1']; ?><br/>
                                        <?php if ($user['address_2']): ?>
                                            <?php echo $user['address_2']; ?><br/>
                                        <?php endif; ?>
                                    <?php echo $user['city'].', '.$state.' '.$user['zip_code']; ?><br/>
                                    <?php echo $country['name']; ?><br/>
                                <?php else: ?>
                                    You have not set a default billing address.<br/>
                                <?php endif; ?>
                                <a href="<?php echo $this->objUrl->href('billing-information'); ?>">
                                    Edit Address
                                </a>
                            </address>
                        </div>
                        <div class="col-2">
                            <h4>Default Shipping Address</h4>
                            <address>
                                <?php if ($defaultShippingAddress): ?>
                                    <?php echo $user['shipping_address_1']; ?><br/>
                                    <?php if ($user['shipping_address_2']): ?>
                                        <?php echo $user['shipping_address_2']; ?><br/>
                                    <?php endif; ?>
                                    <?php echo $user['shipping_city'].', '.$user['shipping_state'].' '.$user['shipping_zip_code']; ?><br/>
                                    <?php echo $shippingCountry['name']; ?><br/>
                                <?php else: ?>
                                    You have not set a default shipping address.<br/>
                                <?php endif; ?>
                                <a href="<?php echo $this->objUrl->href('shipping-information'); ?>">
                                    Edit Address
                                </a>
                            </address>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
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