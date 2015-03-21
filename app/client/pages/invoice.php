<?php

use MyECOMM\Login;
use MyECOMM\Order;
use MyECOMM\Session;
use MyECOMM\Business;
use MyECOMM\Helper;
use MyECOMM\Catalog;

// Restrict access only for logged in users
Login::restrictFront($this->objUrl);

$token = $this->objUrl->get('token');
$items = [];
$user = null;
$business = null;

if (!empty($token)):

    $objOrder = new Order();
    $order = $objOrder->getOrderByToken($token);

    if (!empty($order)):

        if (Session::getSession(Login::$loginFront) == $order['client']):

            $items = $objOrder->getOrderItems($order['id']);
            $objBusiness = new Business();
            $business = $objBusiness->getOne(Business::BUSINESS_ID);
            $objCatalog = new Catalog();

        endif; ?>

        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Invoice</title>
                <link rel="stylesheet" href="/assets/css/invoice.css" type="text/css"/>
            </head>
            <body>
                <section>
                    <div class="container">
                        <h1>Invoice</h1>

                        <div style="width: 50%; float: left;">
                            <p>
                                <strong>Billing Address:</strong><br/>
                                <?php echo $order['full_name']; ?><br/>
                                <?php echo $order['address']; ?><br/>
                                <?php echo $order['city']; ?>,
                                <?php echo $order['state']; ?>
                                <?php echo $order['zip_code']; ?><br/>
                                <?php echo $order['country_name']; ?>
                            </p>
                            <p>
                                <strong>Shipping Address:</strong><br/>
                                <?php echo $order['full_name']; ?><br/>
                                <?php echo $order['shipping_address']; ?><br/>
                                <?php echo $order['shipping_city']; ?>,
                                <?php echo $order['shipping_state']; ?>
                                <?php echo $order['shipping_zip_code']; ?><br/>
                                <?php echo $order['shipping_country_name']; ?>
                            </p>
                        </div>
                        <div style="width: 50%; float: right; text-align: right;">
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
                        <h3>
                            Order ID: <?php echo $order['id']; ?> |
                            Date: <?php echo $order['date_formatted']; ?>
                        </h3>
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
                        <div class="dev">&nbsp;</div>
                        <p>
                            <a href="#" onclick="window.print(); return false;">
                                Print this invoice </a>
                        </p>
                    </div>
                </section>
            </body>
        </html>
<?php else:
        Helper::redirect($this->objUrl->href('error'));
    endif;
else:
    Helper::redirect($this->objUrl->href('error'));
endif; ?>