<?php

use MyECOMM\Login;
use MyECOMM\User;
use MyECOMM\Session;
use MyECOMM\Basket;
use MyECOMM\Shipping;
use MyECOMM\Catalog;
use MyECOMM\Helper;

Login::restrictFront($this->objUrl);

$objUser = new User();
$user = $objUser->getUser(Session::getSession(Login::$loginFront));

if (!empty($user)):

    $objBasket = new Basket($user);

    require_once('_header.php'); ?>

<div class="main checkout pad-bottom">

<?php if (!$objBasket->emptyBasket):

        $objShipping = new Shipping($objBasket);
        $shipping = $objShipping->getShippingOptions($user);

        // Clear any previous shipping sessions
        $objBasket->clearShipping();

        // Get the user's default shipping
        $shippingDefault = $objShipping->getDefault($user);

        if (!empty($shipping) && !empty($shippingDefault)):

            $shippingSelected = $objShipping->getShipping($user, $shippingDefault['id']);

            if ($objBasket->addShipping($shippingSelected)):

                $token1 = mt_rand();
                $token2 = Login::stringToHash($token1);
                Session::setSession('token2', $token2);

                $out = [];

                $session = Session::getSession('basket');

                if (!empty($session)) {
                    $objCatalog = new Catalog();
                    foreach ($session as $key => $value) {
                        $out[$key] = $objCatalog->getProduct($key);
                    }
                }
?>
<div class="page-title">
    <h1>Checkout</h1>
</div>
<?php if (!empty($out)): ?>
<div id="main_basket">
    <form action="" method="POST" id="frm_basket">
        <ol class="checkout-steps">
            <li class="section active" id="checkout-section-order-review">
                <div class="step-title">
                    <span class="number">&nbsp;</span>
                    <h2>Order Review</h2>
                </div>
                <div class="step" id="checkout-step-order-review">
                    <fieldset>
                        <div class="pad-bottom">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="center" rowspan="1">&nbsp;</th>
                                        <th class="center" rowspan="1">
                                            <span class="nobr">Product Name</span>
                                        </th>
                                        <th class="center" rowspan="1">
                                            <span class="nobr">Unit Price</span>
                                        </th>
                                        <th class="center" rowspan="1">
                                            <span class="nobr">Qty</span>
                                        </th>
                                        <th class="center" rowspan="1">
                                            <span class="nobr">Subtotal</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($out as $product):
                                    $image = (!empty($product['image'])) ?
                                        $product['image'] :
                                        'unavailable.png';

                                    $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 60, 90);
                                ?>
                                <tr>
                                    <td class="center">
                                        <img
                                            src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                                            alt="<?php echo Helper::encodeHTML($product['name']); ?>"
                                            width="<?php echo $imageSize['width']; ?>"
                                            height="<?php echo $imageSize['height']; ?>"
                                            />
                                    </td>
                                    <td class="center">
                                        <h2 class="product-name">
                                            <?php echo Helper::encodeHTML($product['name']); ?>
                                        </h2>
                                    </td>
                                    <td class="center">
                                        <span class="cart-price">
                                            <span class="price">
                                                <?php echo $this->objCurrency->display(
                                                    number_format($product['price'], 2)
                                                ); ?>
                                            </span>
                                        </span>
                                    </td>
                                    <td class="center">
                                        <?php echo $session[$product['id']]['quantity']; ?>
                                    </td>
                                    <td class="center">
                                        <span class="cart-price">
                                            <span class="price">
                                                <?php echo $this->objCurrency->display(
                                                    number_format(
                                                        $objBasket->itemTotal(
                                                            $product['price'],
                                                            $session[$product['id']]['quantity']
                                                        ), 2
                                                    )
                                                ); ?>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="5" class="center">
                                            <span>Shipping Methods</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="shipping_types">
                                <?php foreach ($shipping as $srow): ?>
                                <tr>
                                    <td colspan="4">
                                        <input
                                            type="radio"
                                            name="shipping"
                                            id="shipping_<?php echo $srow['id']; ?>"
                                            value="<?php echo $srow['id']; ?>"
                                            class="shipping_radio"
                                            <?php
                                                echo ($srow['id'] == $shippingDefault['id']) ?
                                                    ' checked="checked"' :
                                                    null;
                                                ?>
                                            />
                                        <label for="shipping_<?php echo $srow['id']; ?>">
                                            <?php echo Helper::encodeHTML($srow['name']); ?>
                                        </label>
                                    </td>
                                    <td class="center">
                                        <span>
                                            <span class="price">
                                            <?php
                                                echo $this->objCurrency->display(
                                                    number_format($srow['cost'], 2)
                                                );
                                            ?>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="a-right">
                                            <span><i>Items Total</i></span>
                                        </td>
                                        <td class="center">
                                            <span>
                                                <span class="price">
                                                    <i>
                                                    <?php
                                                        echo $this->objCurrency->display(
                                                            number_format($objBasket->subTotal, 2)
                                                        );
                                                    ?>
                                                    </i>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="a-right">
                                            <span><i>Shipping & Handling</i></span>
                                        </td>
                                        <td class="center" id="basketShippingCost">
                                            <span>
                                                <span class="price">
                                                    <i>
                                                    <?php
                                                        echo $this->objCurrency->display(
                                                            number_format($shippingSelected['cost'], 2)
                                                        );
                                                    ?>
                                                    </i>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="a-right">
                                            <span><i>Subtotal</i></span>
                                        </td>
                                        <td class="center"  id="basketSubTotal">
                                            <span>
                                                <span class="price">
                                                    <i>
                                                        <?php
                                                        echo $this->objCurrency->display(
                                                            number_format($objBasket->finalSubtotal, 2)
                                                        );
                                                        ?>
                                                    </i>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="a-right">
                                            <span><i>Tax</i></span>
                                        </td>
                                        <td class="center" id="basketTax">
                                            <span>
                                                <span class="price">
                                                    <i>
                                                    <?php
                                                        echo $this->objCurrency->display(
                                                            number_format($objBasket->finalTax, 2)
                                                        );
                                                    ?>
                                                    </i>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="a-right">
                                            <span>
                                                <strong>Total</strong>
                                            </span>
                                        </td>
                                        <td class="center" id="basketTotal">
                                            <span>
                                                <span class="price">
                                                    <strong>
                                                    <?php
                                                        echo $this->objCurrency->display(
                                                            number_format($objBasket->finalTotal, 2)
                                                        );
                                                    ?>
                                                    </strong>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="buttons-set" style="position: relative;">
                            <a
                                href="javascript:history.go(-1)"
                                class="left back-btn">
                                <small>« </small>Back
                            </a>
                            <span class="forgot-item-position">
                                Forgot an Item?
                                <a href="<?php echo $this->objUrl->href('cart'); ?>">
                                    Edit Your Cart
                                </a>
                            </span>
                            <button
                                type="button"
                                class="button btn-continue f-right paypal"
                                id="<?php echo $token1; ?>"
                            >
                                <span>
                                    <span>Proceed to PayPal</span>
                                </span>
                            </button>
                        </div>
                    </fieldset>
                </div>
            </li>
        </ol>
    </form>
</div>
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
            else:
                require_once('error-shipping.php');
            endif;
        else:
            require_once('error-shipping.php');
        endif;
    else: ?>
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
else:
    Helper::redirect($this->objUrl->href('error'));
endif; ?>