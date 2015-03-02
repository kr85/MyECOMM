<?php

use MyECOMM\Catalog;
use MyECOMM\Business;
use MyECOMM\Login;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Plugin;

    // Instantiate catalog class
    $objCatalog = new Catalog();
    $categories = $objCatalog->getCategories();

    // Instantiate business class
    $objBusiness = new Business();
    $business = $objBusiness->getOne(Business::BUSINESS_ID);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $this->metaTitle; ?></title>
    <meta name="description" content="<?php echo $this->metaDescription; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/assets/main/all.css" rel="stylesheet" type="text/css"/>
    <script src="../assets/js/lib/modernizr.js" type="text/javascript"></script>
</head>
<body>
    <div class="wrapper">
    <header>
        <div class="header-row-1">
            <div class="header-row-1-container">
                <nav>
                    <ul>
                        <li class="msg-nav-padding">
                            <span class="welcome-msg">Welcome to our online store!</span>
                        </li>
                        <li><a href="">My Account</a></li>
                        <li><a href="">My Wishlist</a></li>
                        <li><a href="">My Cart</a></li>
                        <li><a href="">Checkout</a></li>
                        <li><a href="">Log In</a></li>
                    </ul>
                    <div class="currencies">
                        <label for="currencies">Currencies:</label>
                        <select name="currencies" id="currencies">
                            <option value="USD">USD</option>
                            <option value="GBP">GBP</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                </nav>
            </div>
        </div>
        <div class="header-row-2">
            <div class="header-row-2-container">
                <div class="logo-container">
                    <a href="/" title="Books eCommerce">
                        <img src="/../assets/images/logo.gif" alt="Books eCommerce"/>
                    </a>
                </div>
                <?php if (!empty($categories)): ?>
                    <div class="nav-container">
                        <nav>
                            <ul>
                                <?php foreach ($categories as $c):
                                    echo '<li><a href="';
                                    echo $this->objUrl->href('catalog', ['category', $c['identity']]);
                                    echo '"';
                                    echo $this->objNavigation->active('catalog', ['category' => $c['identity']]);
                                    echo '>';
                                    echo Helper::encodeHTML($c['name']);
                                    echo '</a></li>';
                                endforeach; ?>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!--<div id="header_in" class="container">
            <h5><a href="/"><?php echo $business['name']; ?></a></h5>
            <?php if (Login::isLogged(Login::$loginFront)): ?>
            <div id="logged_as">
                Logged in as: <strong>
                    <?php
                        echo Login::getFullNameFront(
                            Session::getSession(Login::$loginFront)
                        );
                    ?>
                </strong> | <a
                    href="<?php echo $this->objUrl->href('orders'); ?>">
                    My Orders </a> | <a
                    href="<?php echo $this->objUrl->href('logout'); ?>">
                    Log Out </a>
            </div>
            <?php else: ?>
            <div id="logged_as">
                <a href="<?php echo $this->objUrl->href('login'); ?>">
                    Log In </a>
            </div>
            <?php endif; ?>
        </div>-->
    </header>
    <div id="outer">
        <div class="container">
            <?php if ($this->objUrl->currentPage != 'index'): ?>
                <div id="left">
                <?php if ($this->objUrl->currentPage != 'summary'):
                    echo Plugin::get('front'.DS.'basket_left', [
                        'objUrl' => $this->objUrl,
                        'objCurrency' => $this->objCurrency
                    ]);
                endif; ?>
                <?php if (!empty($categories)): ?>
                    <h2>Shop By Category</h2>
                    <ul id="navigation">
                    <?php foreach ($categories as $c):
                        echo '<li><a href="';
                        echo $this->objUrl->href('catalog', ['category', $c['identity']]);
                        echo '"';
                        echo $this->objNavigation->active('catalog', ['category' => $c['identity']]);
                        echo '>';
                        echo Helper::encodeHTML($c['name']);
                        echo '</a></li>';
                    endforeach; ?>
                    </ul>
                <?php endif; ?>
                </div>
            <?php endif; ?>
            <div id="right">