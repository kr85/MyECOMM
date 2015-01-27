<?php
    // Restrict access only for logged in users
    Login::restrictFront();
    
    $id = Url::getParam('id');

    if (!empty($id)) {

        $objOrder = new Order();
        $order = $objOrder->getOrder($id);

        if (!empty($order)) {

            if (Session::getSession(Login::$loginFront) == $order['client']) {

                $items = $objOrder->getOrderItems($id);
                $objCatalog = new Catalog();
                $objUser = new User();
                $user = $objUser->getUser($order['client']);
                $ObjCountry = new Country();
                $ObjBusiness = new Business();
                $business = $ObjBusiness->getBusiness();
                $objBasket = new Basket();
            }
            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Order Invoice</title>
                <link rel="stylesheet" href="/css/invoice.css" type="text/css"/>
            </head>
            <body>
            <div id="wrapper">
                <h1>Order Invoice</h1>

                <div style="width: 50%; float: left;">
                    <p>
                        <strong>To:</strong>
                        <?php echo Login::getFullNameFront($user['id']); ?><br/>
                        <?php echo $user['address_1']; ?><br/>
                        <?php echo !empty($user['address_2']) ? $user['address_2'] : null;
                        ?><br/>
                        <?php echo $user['city']; ?>
                        <?php echo $user['state']; ?>
                        <?php echo $user['zip_code']; ?><br/>
                        <?php
                            $country = $ObjCountry->getCountry($user['country']);
                            echo $country['name'];
                        ?>
                    </p>
                </div>
                <div style="width: 50%; float: right; text-align: right;">
                    <p>
                        <strong><?php echo $business['name']; ?></strong><br/>
                        <?php echo nl2br($business['address']); ?><br/>
                        <?php echo $business['telephone']; ?><br/>
                        <?php echo $business['email']; ?><br/>
                        <?php echo $business['website']; ?>
                    </p>
                </div>

                <div class="dev">&#160;</div>

                <h3>Order Number <?php echo $id; ?></h3>

                <table cellpadding="0" cellspacing="0" border="0"
                       class="tbl_repeat">
                    <tr>
                        <th>Item</th>
                        <th class="ta_r">Qty</th>
                        <th class="ta_r col_15">Price</th>
                    </tr>

                    <?php foreach ($items as $item) { ?>

                        <tr>
                            <td>
                                <?php
                                    $product = $objCatalog->getProduct(
                                        $item['product']
                                    );
                                    echo $product['name'];
                                ?>
                            </td>
                            <td class="ta_r">
                                <?php
                                    echo $item['qty'];
                                ?>
                            </td>
                            <td class="ta_r">
                                <?php
                                    echo Catalog::$currency;
                                    echo number_format($objBasket->itemTotal(
                                        $item['price'],
                                        $item['qty']
                                    ), 2);
                                ?>
                            </td>
                        </tr>

                    <?php } ?>

                    <?php if ($order['tax_rate'] != 0) { ?>

                        <tr>
                            <td colspan="2" class="br_td">
                                Subtotal:
                            </td>
                            <td class="ta_r br_td">
                                <?php
                                    echo Catalog::$currency;
                                    echo number_format($order['subtotal'], 2);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="br_td">
                                Tax (<?php echo $order['tax_rate']; ?>%):
                            </td>
                            <td class="ta_r br_td">
                                <?php
                                    echo Catalog::$currency;
                                    echo number_format($order['tax'], 2);
                                ?>
                            </td>
                        </tr>

                    <?php } ?>

                    <tr>
                        <td colspan="2" class="br_td">
                            <strong>Total:</strong>
                        </td>
                        <td class="ta_r br_td">
                            <strong>
                                <?php
                                    echo Catalog::$currency;
                                    echo number_format($order['subtotal'], 2);
                                ?>
                            </strong>
                        </td>
                    </tr>
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
        }
    }
?>