<?php

use MyECOMM\Plugin;
use MyECOMM\Catalog;
use MyECOMM\Order;
use MyECOMM\Form;
use MyECOMM\Validation;

$objForm = new Form();
$objValidation = new Validation($objForm);

if ($objForm->isPost('order_id')) {
    $objValidation->expected = [
        'order_id',
        'last_name',
        'email',
        'zip_code'
    ];

    $objValidation->required = [
        'order_id',
        'last_name'
    ];

    $orderId = $objForm->getPost('order_id');
    $lastName = $objForm->getPost('last_name');

    if ($objValidation->isValid()) {
        $objOrder = new Order();
        $order = $objOrder->getOrderByIdLastName($orderId, $lastName);

        if (!empty($order)) {

        } else {
            $objValidation->addToErrors('order_not_found');
        }
    }
}

$objCatalog = new Catalog();


require_once('_header.php'); ?>

<div class="main pad-bottom">
    <div class="col-main">
        <div class="breadcrumbs">
            <ul>
                <li class="home">
                    <a href="/" title="Go to Home Page">Home</a>
                    <span>&nbsp;</span>
                </li>
                <li>
                    <strong>
                        Order Information
                    </strong>
                </li>
            </ul>
        </div>
        <div class="description-wrapper">
            <div class="page-title">
                <h2>Returns</h2>
            </div>
            <form action="" method="POST" class="form-valid form-returns">
                <?php echo $objValidation->validate('order_not_found'); ?>
                <div class="row-1">
                    <fieldset>
                        <legend>Order Information</legend>
                        <ul class="form-list">
                            <li class="fields">
                                <div class="field order-id">
                                    <label for="order_id">Order ID: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="order_id"
                                            id="order_id"
                                            class="input"
                                            required="required"
                                            title="Please enter the order id."
                                            />
                                        <?php echo $objValidation->validate('order_id'); ?>
                                    </div>
                                </div>
                            </li>
                            <li style="margin-bottom: 3px">
                                Enter the billing last name and email address / ZIP code as in the order billing address:
                            </li>
                            <li class="fields">
                                <div class="field billing-last-name">
                                    <label for="last_name">Billing Last Name: <em>*</em></label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="last_name"
                                            id="last_name"
                                            class="input"
                                            required="required"
                                            title="Please enter the billing last name."
                                            />
                                        <?php echo $objValidation->validate('last_name'); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field find-by">
                                    <label for="find-by">Find Order By: </label>
                                    <div class="input-box">
                                        <select id="find-by">
                                            <option value="email">Email Address</option>
                                            <option value="zipcode">ZIP Code</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li class="fields">
                                <div class="field email" id="email-address">
                                    <label for="email">Email Address: </label>
                                    <div class="input-box">
                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            title="Please enter a valid email address."
                                            />
                                    </div>
                                </div>
                                <div class="field zip" id="zip-code" style="display: none">
                                    <label for="zip_code">ZIP Code: </label>
                                    <div class="input-box">
                                        <input
                                            type="text"
                                            name="zip_code"
                                            id="zip_code"
                                            title="Please enter a valid ZIP code."
                                            />
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
                        <label for="btn_submit" class="login-btn right">
                            <input
                                type="submit"
                                id="btn_submit"
                                class="login-btn-reset"
                                value="Continue"/>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-right sidebar">
        <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
            'objUrl' => $this->objUrl,
            'objCurrency' => $this->objCurrency,
            'objCatalog' => $objCatalog,
            'listing' => 'category',
            'id' => 0,
            'productId' => 0
        ]); ?>
    </div>
</div>

<?php require_once('_footer.php'); ?>