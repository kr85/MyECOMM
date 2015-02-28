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
                    Helper::redirect(
                        $this->objUrl->getCurrent(
                            ['action', 'id'], false, ['action', 'edited']
                        )
                    );
                } else {
                    Helper::redirect(
                        $this->objUrl->getCurrent(
                            ['action', 'id'], false, ['action', 'edited-failed']
                        )
                    );
                }
            }
        }

        require_once('_header.php');
        ?>
        <h1>Orders :: View</h1>

        <form action="" method="POST">
            <table class="tbl_insert">
                <tr>
                    <th>Date</th>
                    <td colspan="4">
                        <?php echo Helper::setDate(2, $order['date']); ?>
                    </td>
                </tr>
                <tr>
                    <th>Order No.</th>
                    <td colspan="4"><?php echo $order['id']; ?></td>
                </tr>
                <?php if (!empty($items)): ?>
                    <tr>
                        <th rowspan="<?php echo count($items) + 1; ?>">
                            Items:
                        </th>
                        <td class="col_5">Id</td>
                        <td>Item</td>
                        <td class="col_5">Qty</td>
                        <td class="ta_r col_15">Amount</td>
                    </tr>
                    <?php foreach ($items as $item):
                        $product = $objCatalog->getProduct(
                            $item['product']
                        );
                        ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td>
                                <?php echo Helper::encodeHTML(
                                    $product['name']
                                ); ?>
                            </td>
                            <td class="ta_r"><?php echo $item['qty']; ?></td>
                            <td class="ta_r">
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
                        <td colspan="3">
                            <i><?php echo Helper::encodeHTML($order['shipping_type']); ?></i>
                        </td>
                        <td class="ta_r">
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
                        <td colspan="4" class="ta_r">
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
                        <th><i>Tax (<?php echo $order['tax_rate']; ?>%):</i></th>
                        <td colspan="4" class="ta_r">
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
                        <td colspan="4" class="ta_r">
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
                        <div class="sbm sbm_blue fl_r">
                            <a href="<?php echo $this->objUrl->getCurrent(
                                    ['action'], false, ['action', 'invoice']
                                ); ?>" class="btn"
                               target="_blank">Invoice</a>
                        </div>
                        <div class="sbm sbm_blue fl_l mr_r4">
                            <a href="<?php echo $this->objUrl->getCurrent(
                                ['action', 'id']); ?>" class="btn">
                                Go Back
                            </a>
                        </div>
                        <label for="btn_update" class="sbm sbm_blue fl_l">
                            <input type="submit" id="btn_update" class="btn"
                                   value="Update"/>
                        </label>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        require_once('_footer.php');
    }
}
?>