<?php

use MyECOMM\Login;
use MyECOMM\Session;
use MyECOMM\Order;
use MyECOMM\Helper;
use MyECOMM\Catalog;

Login::restrictFront($this->objUrl);

// Clear the basket
Session::clear('basket');

$token = $this->objUrl->get('token');

if (!empty($token)) {

    $objOrder = new Order();
    $order = $objOrder->getOrderByToken($token);

    if (!empty($order)) {

        $items = $objOrder->getOrderItems($order['id']);
        $objCatalog = new Catalog();

        require_once('_header.php');
?>

<div class="main return pad-bottom center">
    <div class="page-title">
        <h1>Thank you</h1>
    </div>
    <p class="break">
        Your order has been received and we are precessing it now. <br/>
        The following is the summary of your order.
    </p>
    <div class="shipping-information">
        <p>
            <strong>Your items will be delivered to:</strong><br/>
            <?php echo $order['full_name']; ?><br/>
            <?php echo $order['shipping_address']; ?><br/>
            <?php echo $order['shipping_city']; ?>,
            <?php echo $order['shipping_state'].' '; ?>
            <?php echo $order['shipping_zip_code']; ?><br/>
            <?php echo $order['shipping_country_name']; ?>
        </p>
        <p>
            <strong>
                Order ID: <?php echo $order['id']; ?> |
                Date: <?php echo $order['date_formatted']; ?>
            </strong>
        </p>
        <fieldset>
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
                <?php
                    foreach ($items as $item):
                        $product = $objCatalog->getProduct($item['product']);
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
                                <?php echo Helper::encodeHTML($item['name']); ?>
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
                            <?php echo $item['qty']; ?>
                        </td>
                        <td class="center">
                            <span class="cart-price">
                                <span class="price">
                                <?php
                                    echo $this->objCurrency->display(
                                        number_format($item['price_total'], 2)
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
                                            number_format($order['subtotal_items'], 2)
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
                                <i>
                                    Shipping & Handling:
                                    <?php
                                        echo $order['shipping_type'];
                                    ?>
                                </i>
                            </span>
                        </td>
                        <td class="center">
                            <span>
                                <span class="price">
                                    <i>
                                        <?php
                                            echo $this->objCurrency->display(
                                                number_format($order['shipping_cost'], 2)
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
                        <td class="center">
                            <span>
                                <span class="price">
                                    <i>
                                        <?php
                                            echo $this->objCurrency->display(
                                                number_format($order['subtotal'], 2)
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
                        <td class="center">
                            <span>
                                <span class="price">
                                    <i>
                                        <?php
                                            echo $this->objCurrency->display(
                                                number_format($order['tax'], 2)
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
                        <td class="center">
                            <span>
                                <span class="price">
                                    <strong>
                                        <?php
                                            echo $this->objCurrency->display(
                                                number_format($order['total'], 2)
                                            );
                                        ?>
                                    </strong>
                                </span>
                            </span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
        <p>
            <a href="#" onclick="window.print(); return false;">Print Confirmation</a>
        </p>
    </div>
</div>
<?php
        require_once('_footer.php');
    } else {
        Helper::redirect($this->objUrl->href('error'));
    }
} else {
    Helper::redirect($this->objUrl->href('error'));
}
?>