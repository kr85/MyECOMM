<?php

use MyECOMM\Login;
use MyECOMM\Order;
use MyECOMM\Business;

// Restrict access only for logged in users
Login::restrictAdmin();

$id = $this->objUrl->get('id');

if (!empty($id)):

    $objOrder = new Order();
    $order = $objOrder->getOrder($id);

    if (!empty($order)):

        $items = $objOrder->getOrderItems($id);
        $ObjBusiness = new Business();
        $business = $ObjBusiness->getOne(Business::BUSINESS_ID);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Invoice</title>
        <link rel="stylesheet" href="/css/invoice.css" type="text/css"/>
    </head>
    <body>
        <div id="wrapper">
            <h1>Invoice</h1>

            <div style="width: 50%; float: left;">
                <p>
                    <strong>Billing Address:</strong>
                    <?php
                        echo $order['full_name'].'<br/>';
                        echo $order['address'].'<br/>';
                        echo $order['city'].', ';
                        echo $order['state'].' ';
                        echo $order['zip_code'].'<br/>';
                        echo $order['country_name'];
                    ?>
                </p>
                <p>
                    <strong>Shipping Address:</strong>
                    <?php
                        echo $order['full_name'].'<br/>';
                        echo $order['shipping_address'].'<br/>';
                        echo $order['shipping_city'].', ';
                        echo $order['shipping_state'].' ';
                        echo $order['shipping_zip_code'].'<br/>';
                        echo $order['shipping_country_name'];
                    ?>
                </p>
            </div>
            <div
                style="width: 50%; float: right; text-align: right;">
                <p>
                    <strong><?php echo $business['name']; ?></strong><br/>
                    <?php echo nl2br($business['address']); ?><br/>
                    <?php echo $business['telephone']; ?><br/>
                    <?php echo $business['email']; ?><br/>
                    <?php echo $business['website']; ?>
                    <?php
                        echo ($order['tax_rate'] > 0 &&
                            !empty($order['tax_number'])) ?
                            '<br/>Tax Number: '.$order['tax_number'] :
                            null;
                    ?>
                </p>
            </div>

            <div class="dev">&#160;</div>

            <h3>Order Number <?php echo $order['id']; ?> |
                Date: <?php echo $order['date']; ?>
            </h3>

            <table class="tbl_repeat">
                <tr>
                    <th>Item</th>
                    <th class="ta_r">Qty</th>
                    <th class="ta_r col_15">Price</th>
                </tr>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <?php echo $item['name']; ?>
                    </td>
                    <td class="ta_r">
                        <?php echo $item['qty']; ?>
                    </td>
                    <td class="ta_r">
                        <?php
                            echo $this->objCurrency->display(
                                number_format($item['price_total'], 2)
                            );
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tbody class="summary_section">
                    <tr>
                        <td colspan="2" class="br_td">
                            <i>Items Total:</i>
                        </td>
                        <td class="ta_r br_td">
                            <i>
                            <?php
                                echo $this->objCurrency->display(
                                    number_format($order['subtotal_items'], 2)
                                );
                            ?>
                            </i>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="br_td">
                            <i>Shipping: <?php echo $order['shipping_type']; ?></i>
                        </td>
                        <td class="ta_r br_td">
                            <i>
                            <?php
                                echo $this->objCurrency->display(
                                    number_format($order['shipping_cost'], 2)
                                );
                            ?>
                            </i>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="br_td">
                            <i>Subtotal:</i>
                        </td>
                        <td class="ta_r br_td">
                            <i>
                            <?php
                                echo $this->objCurrency->display(
                                    number_format($order['subtotal'], 2)
                                );
                            ?>
                            </i>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="br_td">
                            <i>Tax (<?php echo $order['tax_rate']; ?>%):</i>
                        </td>
                        <td class="ta_r br_td">
                            <i>
                            <?php
                                echo $this->objCurrency->display(
                                    number_format($order['tax'], 2)
                                );
                            ?>
                            </i>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="br_td">
                            <strong>Total:</strong>
                        </td>
                        <td class="ta_r br_td">
                            <strong>
                                <?php
                                    echo $this->objCurrency->display(
                                        number_format($order['total'], 2)
                                    );
                                ?>
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="dev br_td">&nbsp;</div>

            <p>
                <a href="#" onclick="window.print(); return false;">
                    Print this invoice
                </a>
            </p>
        </div>
    </body>
</html>
<?php
    endif;
endif;
?>