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
<div class="cart">
    <div class="page-title">
        <h1>Shopping Cart</h1>
    </div>
    <ul class="checkout-types">
        <li>
            <a
                href="<?php echo $data['objUrl']->href('checkout'); ?>"
                class="button btn-cart-checkout"
            >
                <span>
                    <span>Proceed to Checkout</span>
                </span>
            </a>
        </li>
    </ul>
    <form
        action=""
        method="POST"
        id="frm_basket"
        class="form-cart-big"
    >
        <fieldset>
            <table class="data-table cart-table">
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
                        <th class="center" rowspan="1">
                            <span class="nobr">Remove Product</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($out as $product):
                        $image = (!empty($product['image'])) ?
                            $product['image'] :
                            'unavailable.png';

                        $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 60, 90);

                        $link = $data['objUrl']->href('catalog-item', [
                            'item',
                            $product['identity']
                        ]);
                ?>
                    <tr>
                        <td class="center">
                            <a
                                href="<?php echo $link; ?>"
                                title="<?php echo Helper::encodeHTML($product['name']); ?>"
                            >
                                <img
                                    src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                                    alt="<?php echo Helper::encodeHTML($product['name']); ?>"
                                    width="<?php echo $imageSize['width']; ?>"
                                    height="<?php echo $imageSize['height']; ?>"
                                />
                            </a>
                        </td>
                        <td class="center">
                            <h2 class="product-name">
                                <a
                                    href="<?php echo $link; ?>"
                                    title="<?php echo Helper::encodeHTML($product['name']); ?>"
                                >
                                    <?php echo Helper::encodeHTML($product['name']); ?>
                                </a>
                            </h2>
                        </td>
                        <td class="center">
                            <span class="cart-price">
                                <span class="price">
                                    <?php echo $data['objCurrency']->display(
                                        number_format($product['price'], 2)
                                    ); ?>
                                </span>
                            </span>
                        </td>
                        <td class="center">
                            <input
                                type="number"
                                name="qty-<?php echo $product['id']; ?>"
                                id="qty-<?php echo $product['id']; ?>"
                                class="fld_qty"
                                step="1"
                                min="0"
                                value="<?php echo $session[$product['id']]['quantity']; ?>"
                            />
                        </td>
                        <td class="center">
                            <span class="cart-price">
                                <span class="price">
                                    <?php echo $data['objCurrency']->display(
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
                        <td class="center">
                            <?php echo Basket::removeButton($product['id']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="50" class="a-right">
                            <button
                                type="button"
                                class="button btn-continue f-left"
                                onclick="history.go(-1)"
                            >
                                <span>
                                    <span>Continue Shopping</span>
                                </span>
                            </button>
                            <button
                                type="submit"
                                class="button btn-update update_basket"
                            >
                                <span>
                                    <span>Update Shopping Cart</span>
                                </span>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    </form>
    <div class="totals">
        <fieldset>
            <table class="data-table">
                <tbody>
                    <tr>
                        <td class="center">Subtotal</td>
                        <td class="center">
                            <span class="price">
                                <?php echo $data['objCurrency']->display(
                                    number_format($objBasket->subTotal, 2)
                                ); ?>
                            </span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="checkout-types center" colspan="2">
                            <a
                                href="<?php echo $data['objUrl']->href('checkout'); ?>"
                                class="button btn-cart-checkout"
                                >
                                <span>
                                    <span>Proceed to Checkout</span>
                                </span>
                            </a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    </div>
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
<?php endif; ?>