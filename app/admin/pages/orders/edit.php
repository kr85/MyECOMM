<?php

use MyECOMM\Order;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\User;
use MyECOMM\Catalog;
use MyECOMM\Helper;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objOrder = new Order();
    $order = $objOrder->getOrder($id);

    if (!empty($order)) {

        $objForm = new Form();
        $objValidation = new Validation($objForm);

        $objUser = new User();
        $user = $objUser->getUser($order['client']);

        $objCatalog = new Catalog();

        $items = $objOrder->getOrderItems($id);
        $status = $objOrder->getStatuses();

        if ($objForm->isPost('status')) {

            $objValidation->expected = ['status', 'notes'];
            $objValidation->required = ['status'];

            $variables = $objForm->getPostArray($objValidation->expected);

            if ($objValidation->isValid()) {
                if ($objOrder->updateOrder($id, $variables)) {
                    $objValidation->addToSuccess('updated_success');
                } else {
                    $objValidation->addToErrors('updated_failed');
                }
            }
        }

        require_once('_header.php');
        ?>

<div class="order-edit">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="orders">
                <a href="/panel/orders" title="Go to Orders">Orders</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Edit
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Orders :: Edit</h1>
    </div>
    <form action="" method="POST">
        <?php echo $objValidation->validate('updated_success'); ?>
        <?php echo $objValidation->validate('updated_failed'); ?>
        <fieldset>
            <table class="data-table">
                <tr>
                    <th>Date</th>
                    <td colspan="4" class="center bold">
                        <?php echo Helper::setDate(2, $order['date']); ?>
                    </td>
                </tr>
                <tr>
                    <th>Order No.</th>
                    <td colspan="4" class="center bold"><?php echo $order['id']; ?></td>
                </tr>
                <?php if (!empty($items)): ?>
                    <tr>
                        <th rowspan="<?php echo count($items) + 1; ?>">
                            Items:
                        </th>
                        <td class="center order-items-head" rowspan="1">
                            <span class="nobr">Id</span>
                        </td>
                        <td class="center order-items-head" rowspan="1">
                            <span class="nobr">Item</span>
                        </td>
                        <td class="center order-items-head" rowspan="1">
                            <span class="nobr">Qty</span>
                        </td>
                        <td class="center order-items-head" rowspan="1">
                            <span class="nobr">Amount</span>
                        </td>
                    </tr>
                    <?php foreach ($items as $item):
                        $product = $objCatalog->getProduct(
                            $item['product']
                        );
                        ?>
                        <tr>
                            <td class="center"><?php echo $product['id']; ?></td>
                            <td class="center">
                                <?php echo Helper::encodeHTML(
                                    $product['name']
                                ); ?>
                            </td>
                            <td class="center"><?php echo $item['qty']; ?></td>
                            <td class="center">
                                <?php
                                    echo $this->objCurrency->display(
                                        number_format($item['price'] * $item['qty'], 2)
                                    );
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tbody>
                    <tr>
                        <th><i>Shipping:</i></th>
                        <td colspan="3" class="center" style="background-color: #F5F5F5;">
                            <i><?php echo Helper::encodeHTML($order['shipping_type']); ?></i>
                        </td>
                        <td class="center" style="background-color: #F5F5F5;">
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
                        <th><i>Subtotal:</i></th>
                        <td colspan="4" class="ta_r" style="padding-right: 43px;background-color: #F5F5F5;">
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
                        <th><i>Tax:</i></th>
                        <td colspan="4" class="ta_r" style="padding-right: 43px;background-color: #F5F5F5;">
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
                        <th><strong>Total:</strong></th>
                        <td colspan="4" class="ta_r" style="padding-right: 43px;color: #19BDFA;background-color: #F5F5F5;">
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
                <tr>
                    <th>Client:</th>
                    <td colspan="4">
                        <?php
                            echo '<p>';
                            echo Helper::encodeHTML($order['full_name']).'<br/>';
                            echo '<a href="mailto:'.$user['email'].'">';
                            echo $user['email'].'</a>';
                            echo '</p>';
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Billing Address: </th>
                    <td colspan="4">
                        <?php
                            echo '<p>';
                            echo Helper::encodeHTML($order['address']).'<br/>';
                            echo Helper::encodeHTML($order['city']).', ';
                            echo Helper::encodeHTML($order['state']).' ';
                            echo Helper::encodeHTML($order['zip_code']).'<br/>';
                            echo Helper::encodeHTML($order['country_name']);
                            echo '</p>';
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Shipping Address: </th>
                    <td colspan="4">
                        <?php
                            echo '<p>';
                            echo Helper::encodeHTML($order['shipping_address']).'<br/>';
                            echo Helper::encodeHTML($order['shipping_city']).', ';
                            echo Helper::encodeHTML($order['shipping_state']).' ';
                            echo Helper::encodeHTML($order['shipping_zip_code']).'<br/>';
                            echo Helper::encodeHTML($order['shipping_country_name']);
                            echo '</p>';
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>PayPal Status</th>
                    <td colspan="4">
                        <?php
                        echo !empty($order['payment_status']) ?
                            Helper::encodeHTML(
                                $order['payment_status']
                            ) :
                            "Pending";
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="status">Order Status:</label></th>
                    <td colspan="4">
                        <?php $objValidation->validate('status'); ?>
                        <?php if (!empty($status)): ?>
                            <select name="status" id="status" class="sel">
                                <?php foreach ($status as $s): ?>
                                    <option value="<?php echo $s['id']; ?>"
                                        <?php echo $objForm->stickySelect(
                                            'status',
                                            $s['id'],
                                            $order['status']
                                        );
                                        ?>><?php echo Helper::encodeHTML(
                                            $s['name']
                                        ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="notes">Notes</label></th>
                    <td colspan="4">
                        <textarea name="notes" id="notes" cols="" rows=""
                                  class="tar"><?php echo $objForm->stickyText(
                                'notes',
                                $order['notes']
                            );
                            ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td colspan="4">
                        <div class="buttons-set">
                            <a
                                href="/panel/orders"
                                class="left back-btn">
                                <small>« </small>Back
                            </a>
                            <a
                                href="<?php echo $this->objUrl->getCurrent(
                                    ['action'], false, ['action', 'invoice']
                                ); ?>"
                                class="btn-2 right"
                                style="margin-left: 15px;"
                                target="_blank"
                            >
                                <span>Invoice</span>
                            </a>
                            <label for="btn_submit" class="login-btn right">
                                <input
                                    type="submit"
                                    id="btn_submit"
                                    class="login-btn-reset"
                                    value="Update"/>
                            </label>
                            <div class="clearfix"></div>
                        </div>
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>
        <?php
        require_once('_footer.php');
    }
}
?>