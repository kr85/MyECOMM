<?php

use MyECOMM\Plugin;
use MyECOMM\Catalog;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Email;
use MyECOMM\Helper;

$objForm = new Form();
$objValidation = new Validation($objForm);

if ($objForm->isPost('name')) {
    $objValidation->expected = [
        'name',
        'email',
        'comment'
    ];

    $objValidation->required = [
        'name',
        'email',
        'comment'
    ];

    $name = $objForm->getPost('name');
    $email = $objForm->getPost('email');
    $comment = $objForm->getPost('comment');

    if ($objValidation->isValid()) {
        $objEmail = new Email($this->objUrl);
        if ($objEmail->process(2, [
            'name'    => $name,
            'email'   => $email,
            'comment' => $comment,
            'date'    => Helper::setDate()
        ]));
        $objValidation->addToSuccess('email_sent');
    } else {
        $objValidation->addToErrors('email_not_sent');
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
                            Contact Us
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="description-wrapper">
                <div class="page-title">
                    <h2>Contact Us</h2>
                </div>
                <form action="" method="POST" class="form-valid form-contact-us">
                    <?php echo $objValidation->validate('email_not_sent'); ?>
                    <?php echo $objValidation->validate('email_sent'); ?>
                    <div class="row-1">
                        <fieldset>
                            <legend>Contact Information</legend>
                            <ul class="form-list">
                                <li class="fields">
                                    <div class="field name">
                                        <label for="name">Name: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="text"
                                                name="name"
                                                id="name"
                                                class="input"
                                                title="Please enter your name."
                                                />
                                            <?php echo $objValidation->validate('name'); ?>
                                        </div>
                                    </div>
                                </li>
                                <li class="fields">
                                    <div class="field email">
                                        <label for="email">Email Address: <em>*</em></label>
                                        <div class="input-box">
                                            <input
                                                type="email"
                                                name="email"
                                                id="email"
                                                class="input"
                                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                title="Please enter your email address."
                                                />
                                            <?php echo $objValidation->validate('email'); ?>
                                        </div>
                                    </div>
                                </li>
                                <li class="fields-textarea">
                                    <div class="field comment">
                                        <label for="comment">Comment: <em>*</em></label>
                                        <div class="input-box">
                                            <textarea
                                                name="comment"
                                                id="comment"
                                                cols=""
                                                rows=""></textarea>
                                            <?php echo $objValidation->validate('comment'); ?>
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
                                    value="Submit"/>
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
                'productId' => 0,
                'dashboard' => false
            ]); ?>
        </div>
    </div>

<?php require_once('_footer.php'); ?>