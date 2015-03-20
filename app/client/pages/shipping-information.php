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

    if ($objForm->isPost('shipping_first_name')):
        $objValidation->expected = [
            'shipping_first_name',
            'shipping_last_name',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_city',
            'shipping_state',
            'shipping_zip_code',
            'shipping_country',
            'shipping_email'
        ];

        $objValidation->required = [
            'shipping_first_name',
            'shipping_last_name',
            'shipping_address_1',
            'shipping_city',
            'shipping_state',
            'shipping_zip_code',
            'shipping_country',
            'shipping_email'
        ];

        $postArray = $objForm->getPostArray();

        if ($objValidation->isValid()):
            $array = [
                'shipping_first_name' => $postArray['shipping_first_name'],
                'shipping_last_name'  => $postArray['shipping_last_name'],
                'shipping_address_1'  => $postArray['shipping_address_1'],
                'shipping_address_2'  => $postArray['shipping_address_2'],
                'shipping_city'       => $postArray['shipping_city'],
                'shipping_state'      => $postArray['shipping_state'],
                'shipping_zip_code'   => $postArray['shipping_zip_code'],
                'shipping_country'    => $postArray['shipping_country'],
                'shipping_email'      => $postArray['shipping_email']
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
        <div class="col-main shipping-information">
            <div class="page-title">
                <h1>Edit Shipping Information</h1>
            </div>
            <div class="form-wrapper">
                <?php echo $objValidation->validate('update_success'); ?>
                <?php echo $objValidation->validate('update_fail'); ?>
                <form action="" method="POST" class="form-shipping-information">
                    <fieldset>
                        <legend>Shipping Information</legend>
                        <ul class="form-list">
                            <li class="fields">
                                <div class="customer-name">
                                    <div class="field field-two first-name">
                                        <label for="shipping_first_name">First Name: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="shipping_first_name"
                                                id="shipping_first_name"
                                                class="input"
                                                value="<?php echo $objForm->stickyText('shipping_first_name', $user['shipping_first_name']); ?>"
                                                title="Please enter your first name."
                                                />
                                            <?php echo $objValidation->validate('shipping_first_name'); ?>
                                        </div>
                                    </div>
                                    <div class="field field-two last-name">
                                        <label for="shipping_last_name">Last Name: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="shipping_last_name"
                                                id="shipping_last_name"
                                                class="input"
                                                value="<?php echo $objForm->stickyText('shipping_last_name', $user['shipping_last_name']); ?>"
                                                title="Please enter your last name."
                                                />
                                            <?php echo $objValidation->validate('shipping_last_name'); ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one address">
                                    <label for="shipping_address_1">Address 1: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="shipping_address_1"
                                            id="shipping_address_1"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('shipping_address_1', $user['shipping_address_1']); ?>"
                                            title="Please enter the first line of your address."
                                            />
                                        <?php echo $objValidation->validate('shipping_address_1'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one address">
                                    <label for="shipping_address_2">Address 2: </label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="shipping_address_2"
                                            id="shipping_address_2"
                                            class=""
                                            value="<?php echo $objForm->stickyText('shipping_address_2', $user['shipping_address_2']); ?>"
                                            title="Please enter the second line of your address."
                                            />
                                        <?php echo $objValidation->validate('shipping_address_2'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-three city">
                                    <label for="shipping_city">City: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="shipping_city"
                                            id="shipping_city"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('shipping_city', $user['shipping_city']); ?>"
                                            title="Please enter your city."
                                            />
                                        <?php echo $objValidation->validate('shipping_city'); ?>
                                    </div>
                                </div>
                                <div class="field field-three state">
                                    <label for="shipping_state">State/Province: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            id="shipping_state"
                                            name="shipping_state"
                                            value="<?php echo $objForm->stickyText('shipping_state', $user['shipping_state']); ?>"
                                            />
                                        <?php echo $objValidation->validate('shipping_state'); ?>
                                    </div>
                                </div>
                                <div class="field field-three zipcode">
                                    <label for="shipping_zip_code">ZIP Code: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="shipping_zip_code"
                                            id="shipping_zip_code"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('shipping_zip_code', $user['shipping_zip_code']); ?>"
                                            title="Please enter your zipcode."
                                            />
                                        <?php echo $objValidation->validate('shipping_zip_code'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one country">
                                    <label for="shipping_country">Country: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objForm->getCountriesSelect(
                                            $user['shipping_country'],
                                            'shipping_country',
                                            false,
                                            'create-account-country select_country_state'
                                        ); ?>
                                        <?php echo $objValidation->validate('shipping_country'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one email">
                                    <label for="shipping_email">Email Address: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="email"
                                            name="shipping_email"
                                            id="shipping_email"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('shipping_email', $user['shipping_email']); ?>"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            autocomplete="off"
                                            title="Please enter a valid email address."
                                            />
                                        <?php echo $objValidation->validate('shipping_email'); ?>
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