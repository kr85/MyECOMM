<?php

    Login::restrictFront($this->objUrl);

    $objUser = new User();
    $user = $objUser->getUser(Session::getSession(Login::$loginFront));

    if (!empty($user)):

        $objBasket = new Basket($user);
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

                require_once('_header.php');
?>

<h1>Order Summary</h1>

<?php if (!empty($out)): ?>
<div id="main_basket">
    <form action="" method="POST" id="frm_basket">
        <table class="tbl_repeat br_bd">
            <tr>
                <th>Item</th>
                <th class="ta_r">Qty</th>
                <th class="ta_r col_15">Price</th>
            </tr>
            <?php foreach ($out as $item): ?>
            <tr>
                <td>
                <?php echo $item['name']; ?>
                </td>
                <td class="ta_r">
                <?php echo $session[$item['id']]['quantity']; ?>
                </td>
                <td class="ta_r">
                <?php
                    echo Catalog::$currency;
                    echo number_format(
                        $objBasket->itemTotal(
                            $item['price'],
                            $session[$item['id']]['quantity']
                        ),
                        2
                    );
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td class="dev">&#160;</td>
            </tr>
            <tr class="row_highlight">
                <td colspan="2" class="br_td">
                    <i>Items Total:</i>
                </td>
                <td class="ta_r br_td">
                    <i>
                    <?php
                        echo Catalog::$currency;
                        echo number_format($objBasket->subTotal, 2);
                    ?>
                    </i>
                </td>
            </tr>
            <tr>
                <th colspan="3">Shipping</th>
            </tr>
            <?php foreach ($shipping as $srow): ?>
            <tr>
                <td colspan="2">
                    <label for="shipping_<?php echo $srow['id']; ?>">
                        <input
                            type="radio"
                            name="shipping"
                            id="shipping_<?php echo $srow['id']; ?>"
                            value="<?php echo $srow['id']; ?>"
                            class="shipping_radio"
                            <?php
                                echo ($srow['id'] == $shippingDefault) ?
                                ' checked="checked"' :
                                null;
                            ?>
                        />
                        <?php echo Helper::encodeHTML($srow['name']); ?>
                    </label>
                </td>
                <td class="ta_r">
                <?php
                    echo Catalog::$currency;
                    echo number_format($srow['cost'], 2);
                ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <tbody class="row_highlight">
                <tr>
                    <td colspan="2" class="br_td">
                        Subtotal:
                    </td>
                    <td class="ta_r br_td" id="basketSubTotal">
                    <?php
                        echo Catalog::$currency;
                        echo number_format(
                            $objBasket->finalSubtotal,
                            2
                        );
                    ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="br_td">
                        Tax (<?php echo $objBasket->taxRate; ?>%)
                    </td>
                    <td class="ta_r br_td" id="basketTax">
                    <?php
                        echo Catalog::$currency;
                        echo number_format($objBasket->finalTax, 2);
                    ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="br_td">
                        <strong>Total:</strong>
                    </td>
                    <td class="ta_r br_td">
                        <strong id="basketTotal">
                        <?php
                            echo Catalog::$currency;
                            echo number_format($objBasket->finalTotal, 2);
                        ?>
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="sbm sbm_blue fl_r paypal" id="<?php echo $token1; ?>">
            <span class="btn">
                Proceed to PayPal
            </span>
        </div>
        <div class="sbm sbm_blue fl_l">
            <a href="<?php echo $this->objUrl->href('basket'); ?>" class="btn">
                Continue Shopping
            </a>
        </div>
    </form>
    <div class="dev">&#160;</div>
</div>

<?php else: ?>
    <p>Your basket is currently empty.</p>
<?php endif;
                require_once('_footer.php');
            else:
                //require_once('error-shipping.php');
                echo 'Error 1';
            endif;
        else:
            //require_once('error-shipping.php');
            echo 'Error 2';
        endif;
    else:
        Helper::redirect($this->objUrl->href('error'));
    endif;
?>