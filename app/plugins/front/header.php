<?php

use MyECOMM\Login;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Plugin;
use MyECOMM\Catalog;

$objCatalog = (is_object($data['objCatalog'])) ? $data['objCatalog'] : new Catalog();

?>

<div class="header-row-1">
    <div class="header-row-1-container">
        <nav>
            <ul>
                <li class="msg-nav-padding">
                    <span class="welcome-msg">Welcome to our online store!</span>
                </li>
                <li>
                    <a
                        href="<?php echo $data['objUrl']->href('orders'); ?>"
                        title="My Account"
                    >
                        My Account
                    </a>
                </li>
                <li>
                    <a
                        href="<?php echo $data['objUrl']->href('wishlist'); ?>"
                        title="My Wishlist"
                    >
                        My Wishlist
                    </a>
                </li>
                <li class="my-cart-items">
                    <a
                        href="<?php echo $data['objUrl']->href('cart'); ?>"
                        title="My Cart"
                    >
                        My Cart
                    </a>
                </li>
                <li>
                    <a
                        href="<?php echo $data['objUrl']->href('checkout'); ?>"
                        title="Checkout"
                    >
                        Checkout
                    </a>
                </li>
                <?php if (Login::isLogged(Login::$loginFront)): ?>
                <li>
                    <a
                        href="<?php echo $data['objUrl']->href('logout'); ?>"
                        title="Log Out"
                    >
                        Log Out
                    </a>
                </li>
                <?php else: ?>
                <li>
                    <a
                        href="<?php echo $data['objUrl']->href('login'); ?>"
                        title="Log In"
                    >
                        Log In
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <div class="logged_as">
                Browse as:
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
                <img src="<?php echo DS.ASSETS_DIR.DS.IMAGES_DIR.DS.'logo.gif'; ?>" alt="Books eCommerce"/>
            </a>
        </div>
        <div class="search-container">
            <form
                action="<?php echo $data['objUrl']->href('catalog'); ?>"
                method="post"
                id="form-search"
            >
                <div class="form-search">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value=""
                        class="input-text"
                        placeholder="Search..."
                    />
                    <input
                        type="submit"
                        value=""
                        title="Search"
                        class="btn-search"
                    />
                </div>
            </form>
        </div>
        <?php if (!empty($data['sections'])): ?>
        <div class="nav-container">
            <nav>
                <ul>
                    <?php foreach ($data['sections'] as $section):
                        echo '<li class="sub-nav" id="';
                        echo $section['id'];
                        echo '"><a href="';
                        echo $data['objUrl']->href('catalog', ['section', $section['identity']]);
                        echo '"';
                        echo $data['objNavigation']->active('catalog', ['section' => $section['identity']]);
                        echo '>';
                        echo Helper::encodeHTML($section['name']);
                        echo '</a>';
                        echo '<ul id="';
                        echo 'sub-nav-'.$section['id'];
                        echo '" class="sub-nav-wrapper sub-nav-wrapper-hidden">';
                        foreach ($objCatalog->getCategoriesBySection($section['id']) as $cat):
                            echo '<li>';
                            echo '<a class="sub-nav-text" href="';
                            echo $data['objUrl']->href('catalog', ['category', $cat['identity']]);
                            echo '">';
                            echo '<span>';
                            echo $cat['name'];
                            echo '</span>';
                            echo '</a>';
                            echo '</li>';
                        endforeach;
                        echo '</ul>';
                        echo '</li>';
                    endforeach; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
        <?php
            if ($data['objUrl']->currentPage == 'index'):
                echo Plugin::get('front'.DS.'new_products', [
                    'objUrl' => $data['objUrl'],
                    'objCatalog' => $objCatalog,
                    'latestProducts' => $data['latestProducts']
                ]);
            endif;
        ?>
    </div>
</div>