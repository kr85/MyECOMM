<?php

use MyECOMM\Login;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Plugin;

?>

<div class="header-row-1">
    <div class="header-row-1-container">
        <nav>
            <ul>
                <li class="msg-nav-padding">
                    <span class="welcome-msg">Welcome to our online store!</span>
                </li>
                <li><a href="<?php echo $data['objUrl']->href('orders'); ?>" title="My Account">My Account</a></li>
                <li><a href="" title="My Wishlist">My Wishlist</a></li>
                <li class="my-cart-items">
                    <a href="<?php echo $data['objUrl']->href('basket'); ?>" title="My Cart">My Cart
                                <span class="h_ti">
                                </span>
                    </a>
                </li>
                <li><a href="<?php echo $data['objUrl']->href('checkout'); ?>" title="Checkout">Checkout</a></li>
                <?php if (Login::isLogged(Login::$loginFront)): ?>
                    <li><a href="<?php echo $data['objUrl']->href('logout'); ?>" title="Log Out">Log Out</a></li>
                <?php else: ?>
                    <li><a href="<?php echo $data['objUrl']->href('login'); ?>" title="Log In">Log In</a></li>
                <?php endif; ?>
            </ul>
            <div class="logged_as">
                Logged in as:
                <strong>
                <?php if (Login::isLogged(Login::$loginFront)): ?>
                    <?php echo Login::getFullNameFront(
                            Session::getSession(Login::$loginFront)
                        ); ?>
                <?php else: ?>
                    Guest
                <?php endif; ?>
                </strong>
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
        <?php if (!empty($data['categories'])): ?>
        <div class="nav-container">
            <nav>
                <ul>
                    <?php foreach ($data['categories'] as $c):
                        echo '<li><a href="';
                        echo $data['objUrl']->href('catalog', ['category', $c['identity']]);
                        echo '"';
                        echo $data['objNavigation']->active('catalog', ['category' => $c['identity']]);
                        echo '>';
                        echo Helper::encodeHTML($c['name']);
                        echo '</a></li>';
                    endforeach; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
        <?php
            if ($data['objUrl']->currentPage == 'index'):
                echo Plugin::get('front'.DS.'new_products', [
                    'objUrl' => $data['objUrl'],
                    'products' => $data['products']
                ]);
            endif;
        ?>
    </div>
</div>