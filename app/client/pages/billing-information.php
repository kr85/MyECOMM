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

    if ($objForm->isPost('first_name')):
        $objValidation->expected = [
            'first_name',
            'last_name',
            'address_1',
            'address_2',
            'city',
            'state',
            'zip_code',
            'country'
        ];

        $objValidation->required = [
            'first_name',
            'last_name',
            'address_1',
            'city',
            'state',
            'zip_code',
            'country'
        ];

        $postArray = $objForm->getPostArray();

        if ($objValidation->isValid()):
            $array = [
                'first_name' => $postArray['first_name'],
                'last_name'  => $postArray['last_name'],
                'address_1'  => $postArray['address_1'],
                'address_2'  => $postArray['address_2'],
                'city'       => $postArray['city'],
                'state'      => $postArray['state'],
                'zip_code'   => $postArray['zip_code'],
                'country'    => $postArray['country']
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
        <div class="col-main billing-information">
            <div class="page-title">
                <h1>Edit Billing Information</h1>
            </div>
            <div class="form-wrapper">
                <?php echo $objValidation->validate('update_success'); ?>
                <?php echo $objValidation->validate('update_fail'); ?>
                <form action="" method="POST" class="form-billing-information">
                    <fieldset>
                        <legend>Billing Information</legend>
                        <ul class="form-list">
                            <li class="fields">
                                <div class="customer-name">
                                    <div class="field field-two first-name">
                                        <label for="first_name">First Name: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="first_name"
                                                id="first_name"
                                                class="input"
                                                value="<?php echo $objForm->stickyText('first_name', $user['first_name']); ?>"
                                                title="Please enter your first name."
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
                                            />
                                        <?php echo $objValidation->validate('city'); ?>
                                    </div>
                                </div>
                                <div class="field field-three state">
                                    <label for="state">State/Province: <em>*</em></label>
                                    <div class="input-box">
                                        <?php echo $objForm->getCountryStatesSelect('input', $user['country'], $user['state']); ?>
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