<?php

    $id = $this->objUrl->get('id');

    if (!empty($id)) {

        $objOrder = new Order();
        $order = $objOrder->getOrder($id);

        if (!empty($order)) {

            $objForm = new Form();
            $objValidation = new Validation($objForm);

            $objUser = new User();
            $user = $objUser->getUser($order['client']);

            $objCountry = new Country();

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
                                [
                                    'action',
                                    'id'
                                ]
                            ) . '/action/edited'
                        );
                    } else {
                        Helper::redirect(
                            $this->objUrl->getCurrent(
                                [
                                    'action',
                                    'id'
                                ]
                            ) . '/action/edited-failed'
                        );
                    }
                }
            }

            require_once('_header.php');
            ?>
            <h1>Orders :: View</h1>

            <form action="" method="POST">
                <table cellpadding="0" cellspacing="0" border="0"
                       class="tbl_insert">
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
                    <?php if (!empty($items)) { ?>
                        <tr>
                            <th rowspan="<?php echo count($items) + 1; ?>">
                                Items:
                            </th>
                            <td class="col_5">Id</td>
                            <td>Item</td>
                            <td class="col_5">Qty</td>
                            <td class="ta_r col_15">Amount</td>
                        </tr>
                        <?php foreach ($items as $item) {
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
                                        echo Catalog::$currency;
                                        echo number_format(
                                            $item['price'] * $item['qty'],
                                            2
                                        );
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    <tr>
                        <th>Subtotal:</th>
                        <td colspan="4" class="ta_r">
                            <?php
                                echo Catalog::$currency;
                                echo number_format($order['subtotal'], 2);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tax (<?php echo $order['tax_rate']; ?>%):</th>
                        <td colspan="4" class="ta_r">
                            <?php
                                echo Catalog::$currency;
                                echo number_format($order['tax'], 2);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td colspan="4" class="ta_r">
                            <strong>
                                <?php
                                    echo Catalog::$currency;
                                    echo number_format($order['total'], 2);
                                ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Client:</th>
                        <td colspan="4">
                            <?php
                                echo Helper::encodeHTML(
                                        $user['first_name'] . " " . $user['last_name']
                                    ) . '<br/>';
                                echo Helper::encodeHTML(
                                        $user['address_1']
                                    ) . '<br/>';
                                echo Helper::encodeHTML(
                                        $user['address_2']
                                    ) . '<br/>';
                                echo Helper::encodeHTML($user['city']) . ', ';
                                echo Helper::encodeHTML($user['state']) . ' ';
                                echo Helper::encodeHTML(
                                        $user['zip_code']
                                    ) . '<br/>';
                                $country = $objCountry->getCountry(
                                    $user['country']
                                );
                                echo Helper::encodeHTML(
                                        $country['name']
                                    ) . '<br/>';
                                echo '<a href="mailto:' . $user['email'] . '">';
                                echo $user['email'] . '</a>';
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
                            <?php if (!empty($status)) { ?>
                                <select name="status" id="status" class="sel">
                                    <?php foreach ($status as $s) { ?>
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
                                    <?php } ?>
                                </select>
                            <?php } ?>
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
                                        [
                                            'action'
                                        ]
                                    ) . '/action/invoice'; ?>" class="btn"
                                   target="_blank"> Invoice </a>
                            </div>
                            <div class="sbm sbm_blue fl_l mr_r4">
                                <a href="<?php echo $this->objUrl->getCurrent(
                                    [
                                        'action',
                                        'id'
                                    ]
                                ); ?>" class="btn"> Go Back </a>
                            </div>
                            <label for="btn_update" class="sbm sbm_blue fl_l">
                                <input type="submit" id="btn_update" class="btn"
                                       value="Update"/> </label>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
            require_once('_footer.php');
        }
    }
?>