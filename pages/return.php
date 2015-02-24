<?php

    // Clear the basket
    Session::clear('basket');

    $token = $this->objUrl->get('token');

    if (!empty($token)) {

        $objOrder = new Order();
        $order = $objOrder->getOrderByToken($token);

        if (!empty($order)) {

            $items = $objOrder->getOrderItems($order['id']);

            require_once('_header.php');
?>

<h1>Thank you</h1>

<p>
    Your order has been received and we are precessing it now. <br />
    The following is the summary of your order.
</p>

<div class="dev br_td">&nbsp;</div>

<p>
    <strong>Your items will be delivered to:</strong><br />
    <?php echo $order['full_name']; ?>,
    <?php echo $order['shipping_address']; ?>,
    <?php echo $order['shipping_city']; ?>,
    <?php echo $order['shipping_state']; ?>,
    <?php echo $order['shipping_zip_code']; ?>,
    <?php echo $order['shipping_country']; ?>
</p>

<p>
    <strong>
        Order Number <?php echo $order['id']; ?> /
        Date <?php echo $order['date_formatted']; ?>
    </strong>
</p>

<table class="tbl_repeat br_bd">
    <thead>
        <tr>
            <th>Item</th>
            <th class="ta_r">Qty</th>
            <th class="ta_r col_15">Price</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td class="ta_r"><?php echo $item['quantity']; ?></td>
            <td class="ta_r">
                <?php
                    echo Catalog::$currency . number_format($item['price_total'], 2);
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tbody class="row_highlight">
        <tr>
            <td colspan="2" class="br_td">
                <i>Items Total:</i>
            </td>
            <td class="ta_r br_td">
                <i>
                    <?php
                        echo Catalog::$currency .
                            number_format($order['subtotal_items'], 2);
                    ?>
                </i>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="br_td">
                Shipping: <?php echo $order['shipping_type']; ?>
            </td>
            <td class="ta_r br_td">
                <?php
                    echo Catalog::$currency .
                        number_format($order['shipping_cost'], 2);
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="br_td">
                Subtotal:
            </td>
            <td class="ta_r br_td">
                <?php
                    echo Catalog::$currency .
                        number_format($order['subtotal'], 2);
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="br_td">
                Tax (<?php echo $order['tax_rate']; ?>%):
            </td>
            <td class="ta_r br_td">
                <?php
                    echo Catalog::$currency .
                        number_format($order['tax'], 2);
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="br_td">
                Total:
            </td>
            <td class="ta_r br_td">
                <strong>
                    <?php
                        echo Catalog::$currency .
                            number_format($order['total'], 2);
                    ?>
                </strong>
            </td>
        </tr>
    </tbody>
</table>

<p><a href="#" onclick="window.print(); return false;">Print Confirmation</a></p>

<?php
            require_once('_footer.php');
        } else {
            Helper::redirect($this->objUrl->href('error'));
        }
    } else {
        Helper::redirect($this->objUrl->href('error'));
    }
?>