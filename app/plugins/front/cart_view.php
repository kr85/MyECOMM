<?php

use MyECOMM\Session;
use MyECOMM\Basket;
use MyECOMM\Catalog;
use MyECOMM\Helper;

$session = Session::getSession('basket');
$objBasket = new Basket();
$out = [];

if (!empty($session)) {

    $objCatalog = new Catalog();

    foreach ($session as $key => $value) {
        $out[$key] = $objCatalog->getProduct($key);
    }
}

if (!empty($out)): ?>
<form action="" method="POST" id="frm_basket">
    <table class="tbl_repeat tr_bd">
        <thead>
            <tr>
                <th>Item</th>
                <th class="ta_r">Qty</th>
                <th class="ta_r col_15">Price</th>
                <th class="ta_r col_15">Remove</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($out as $item): ?>
            <tr>
                <td>
                    <?php echo Helper::encodeHTML($item['name']); ?>
                </td>
                <td>
                    <input type="text"
                           name="qty-<?php echo $item['id']; ?>"
                           id="qty-<?php echo $item['id']; ?>"
                           class="fld_qty"
                           value="<?php echo $session[$item['id']]['quantity'];
                           ?>"/>
                </td>
                <td class="ta_r">
                    <?php
                        echo $data['objCurrency']->display(
                            number_format(
                                $objBasket->itemTotal(
                                    $item['price'],
                                    $session[$item['id']]['quantity']
                                ), 2
                            ));
                    ?>
                </td>
                <td class="ta_r">
                    <?php echo Basket::removeButton($item['id']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="2" class="br_td">Subtotal:</td>
                <td class="ta_r br_td">
                    <?php
                        echo $data['objCurrency']->display(
                            number_format($objBasket->subTotal, 2)
                        );
                    ?>
                </td>
                <td class="ta_r br_td">&#160;</td>
            </tr>
        </tbody>
    </table>

    <div class="sbm sbm_blue fl_r">
        <a href="<?php echo $data['objUrl']->href('checkout'); ?>" class="btn">
            Checkout
        </a>
    </div>

    <div class="sbm sbm_blue fl_l update_basket">
        <span class="btn">Update</span>
    </div>
</form>
<div class="dev">&#160;</div>
<?php else: ?>
    <div class="page-title">
        <h1>Shopping Cart is Empty</h1>
    </div>
    <p class="empty">
        You have <strong>no items</strong> in your shopping cart.<br/>
        Click <a href="/">here</a> to continue shopping.
    </p>
<?php endif; ?>