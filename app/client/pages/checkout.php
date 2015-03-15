<?php

use MyECOMM\Login;
use MyECOMM\User;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Basket;

// Restrict access only for logged in users
Login::restrictFront($this->objUrl);

$objUser = new User();
$user = $objUser->getUser(Session::getSession(Login::$loginFront));

if (!empty($user)) {

    $objBasket = new Basket($user);

    require_once('_header.php'); ?>

<div class="main checkout pad-bottom">

<?php if (!$objBasket->emptyBasket):

        $objForm = new Form();
        $objValidation = new Validation($objForm);

        // Checkout form
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
                'same_address',
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
                'same_address'
            ];

            // Special validation field
            $objValidation->special = [
                'email' => 'email'
            ];

            $array = $objForm->getPostArray($objValidation->expected);

            if (empty($array['same_address'])) {
                $objValidation->required[] = 'shipping_first_name';
                $objValidation->required[] = 'shipping_last_name';
                $objValidation->required[] = 'shipping_address_1';
                $objValidation->required[] = 'shipping_city';
                $objValidation->required[] = 'shipping_state';
                $objValidation->required[] = 'shipping_zip_code';
                $objValidation->required[] = 'shipping_country';
                $objValidation->required[] = 'shipping_email';
            } else {
                $array['shipping_first_name'] = null;
                $array['shipping_last_name'] = null;
                $array['shipping_address_1'] = null;
                $array['shipping_address_2'] = null;
                $array['shipping_city'] = null;
                $array['shipping_state'] = null;
                $array['shipping_zip_code'] = null;
                $array['shipping_country'] = null;
                $array['shipping_email'] = null;
            }

            // Check if validation was successful
            if ($objValidation->isValid($array)) {
                if ($objUser->updateUser($objValidation->post, $user['id'])) {
                    Helper::redirect($this->objUrl->href('summary'));
                } else {
                    $message = "There are a problem updating your details. ";
                    $message .= "Please contact the administrator.";
                    $objValidation->addToErrors('update_info_error', $message);
                }
            }
        }
    ?>
    <div class="page-title">
        <h1>Checkout</h1>
    </div>
    <?php echo $objValidation->validate('update_info_error'); ?>
    <form action="" method="post">
        <ol class="checkout-steps">
            <li class="section active" id="checkout-section-billing">
                <div class="step-title">
                    <span class="number">&nbsp;</span>
                    <h2>Billing Information</h2>
                </div>
                <div class="step" id="checkout-step-billing">
                    <fieldset>
                        <ul class="form-list">
                            <li class="fields">
                                <div class="customer-name">
                                    <div class="field field-two first-name">
                                        <label for="first_name" class="">First Name: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="first_name"
                                                id="first_name"
                                                class="input"
                                                value="<?php echo $objForm->stickyText('first_name', $user['first_name']); ?>"
                                                title="Please enter your first name."
                                                required="required"
                                                />
                                            <?php echo $objValidation->validate('first_name'); ?>
                                        </div>
                                    </div>
                                    <div class="field field-two last-name">
                                        <label for="last_name">Last Name: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="last_name"
                                                id="last_name"
                                                class="input"
                                                value="<?php echo $objForm->stickyText('last_name', $user['last_name']); ?>"
                                                title="Please enter your last name."
                                                required="required"
                                                />
                                            <?php echo $objValidation->validate('last_name'); ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one address">
                                    <label for="address_1">Address 1: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="address_1"
                                            id="address_1"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('address_1', $user['address_1']); ?>"
                                            title="Please enter the first line of your address."
                                            required="required"
                                            />
                                        <?php echo $objValidation->validate('address_1'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one address">
                                    <label for="address_2">Address 2: </label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="address_2"
                                            id="address_2"
                                            class=""
                                            value="<?php echo $objForm->stickyText('address_2', $user['address_2']); ?>"
                                            title="Please enter the second line of your address."
                                            />
                                        <?php echo $objValidation->validate('address_2'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-three city">
                                    <label for="city">City: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="city"
                                            id="city"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('city', $user['city']); ?>"
                                            title="Please enter your city."
                                            required="required"
                                            />
                                        <?php echo $objValidation->validate('city'); ?>
                                    </div>
                                </div>
                                <div class="field field-three state">
                                    <label for="state">State/Province: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objForm->getCountryStatesSelect($user['country'], $user['state']); ?>
                                        <?php echo $objValidation->validate('state'); ?>
                                    </div>
                                </div>
                                <div class="field field-three zipcode">
                                    <label for="zip_code">ZIP Code: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="zip_code"
                                            id="zip_code"
                                            class="input"
                                            value="<?php echo $objForm->stickyText('zip_code', $user['zip_code']); ?>"
                                            title="Please enter your zipcode."
                                            required="required"
                                            />
                                        <?php echo $objValidation->validate('zip_code'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field field-one country">
                                    <label for="country">Country: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objForm->getCountriesSelect(
                                            $user['country'],
                                            'country',
                                            false,
                                            'create-account-country select_country_state'
                                        ); ?>
                                        <?php echo $objValidation->validate('country'); ?>
                                    </div>
                                </div>
                            </li>
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
                                            required="required"
                                            />
                                        <?php echo $objValidation->validate('email'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="control">
                                <input
                                    type="radio"
                                    name="same_address"
                                    id="same_address_1"
                                    value="1"
                                    class="show_hide_radio"
                                    <?php echo $objForm->stickyRadio(
                                        'same_address', 1, $user['same_address']
                                    ); ?>
                                    />
                                <label for="same_address_1">
                                    Ship to This Address
                                </label>
                            </li>
                            <li class="control">
                                <input
                                    type="radio"
                                    name="same_address"
                                    id="same_address_0"
                                    value="0"
                                    class="show_hide_radio"
                                    <?php echo $objForm->stickyRadio(
                                        'same_address', 0, $user['same_address']
                                    ); ?>
                                    />
                                <label for="same_address_0">
                                    Ship to Different Address
                                </label>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </fieldset>
                </div>
            </li>
            <li id="deliveryAddress" class="section active same_address<?php
            echo $objForm->stickyRemoveClass(
                'same_address', 0, $user['same_address'], 'dn'
            ); ?>">
                <div class="step-title">
                    <span class="number">&nbsp;</span>
                    <h2>Shipping Information</h2>
                </div>
                <form action="" method="post">
                    <div class="step" id="checkout-step-shipping">
                        <fieldset>
                            <ul class="form-list">
                                <li class="fields">
                                    <div class="customer-name">
                                        <div class="field field-two first-name">
                                            <label for="shipping_first_name" class="">First Name: <em>*</em></label>
                                            <div class="input-box">
                                                <input
                                                    type="text"
                                                    name="shipping_first_name"
                                                    id="shipping_first_name"
                                                    class="input"
                                                    value="<?php echo $objForm->stickyText('shipping_first_name', $user['shipping_first_name']); ?>"
                                                    title="Please enter a first name."
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
                                                    title="Please enter a last name."
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
                                                title="Please enter the first line of the address."
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
                                                value="<?php echo $objForm->stickyText('shipping_address_2', $user['shipping_address_2']); ?>"
                                                title="Please enter the second line of the address."
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
                                                title="Please enter a city."
                                                />
                                            <?php echo $objValidation->validate('shipping_city'); ?>
                                        </div>
                                    </div>
                                    <div class="field field-three state">
                                        <label for="shipping_state">State/Province: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="shipping_state"
                                                id="shipping_state"
                                                class="input shipping_state"
                                                value="<?php echo $objForm->stickyText('shipping_state', $user['shipping_state']); ?>"
                                                title="Please enter a state."
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
                                                title="Please enter a zipcode."
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
                                                'create-account-country select_country_state_shipping',
                                                false
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
                                <li class="control">
                                    <input
                                        type="checkbox"
                                        name="same_address_check"
                                        id="same_address_check"
                                        value="0"
                                        />
                                    <label for="same_address_check">
                                        Use Billing Information
                                    </label>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </fieldset>
                    </div>
                </form>
            </li>
            <li class="section-buttons">
                <div class="step step-buttons">
                    <div class="buttons-set">
                        <p class="required">* Required Fields</p>
                        <a
                            href="javascript:history.go(-1)"
                            class="left back-btn">
                            <small>« </small>Back
                        </a>
                        <button type="submit" class="button btn-continue f-right">
                            <span>
                                <span>Continue</span>
                            </span>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </li>
        </ol>
    </form>
<?php else: ?>
    <div class="center">
        <div class="page-title">
            <h1>Shopping Cart is Empty</h1>
        </div>
        <p class="empty">
            You have <strong>no items</strong> in your shopping cart.<br/>
            Click <a href="/">here</a> to continue shopping.
        </p>
    </div>
</div>
<?php endif;
    require_once('_footer.php');
} else {
    Helper::redirect($this->objUrl->href('error'));
}
?>