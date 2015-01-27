<?php

    $objOrder = new Order();
    $search = Url::getParam('srch');

    if (!empty($search)) {
        $orders = $objOrder->getAllOrders($search);
        $empty = 'There are no results matching your search criteria.';

    } else {
        $orders = $objOrder->getAllOrders();
        $empty = 'There are currently no records.';
    }

    $objPaging = new Paging($orders, 5);
    $rows = $objPaging->getRecords();
    $objPaging->url = '/admin' . $objPaging->url;

    require_once('templates/_header.php'); ?>

    <h1>Orders</h1>

    <form action="" method="GET">
        <?php echo Url::getParamsForSearch('srch', Paging::$key); ?>
        <table cellspacing="0" cellpadding="0" border="0" class="tbl_insert">
            <tr>
                <th>
                    <label for="srch">
                        Order No.:
                    </label>
                </th>
                <td>
                    <input type="text" name="srch" id="srch"
                           value="<?php echo stripslashes($search); ?>"
                           class="fld"/>
                </td>
                <td>
                    <label for="btn_add" class="sbm sbm_blue fl_l">
                        <input type="submit" id="btn_add" class="btn"
                               value="Search"/>
                    </label>
                </td>
            </tr>
        </table>
    </form>

<?php
    if (!empty($rows)) {
        ?>
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
            <tr>
                <th class="col_15">Id</th>
                <th>Date</th>
                <th class="ta_r col_15">Total</th>
                <th class="ta_r col_15">Status</th>
                <th class="ta_r col_15">PP Status</th>
                <th class="ta_r col_15">Remove</th>
                <th class="ta_r col_15">View</th>
            </tr>
            <?php foreach ($rows as $order) { ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo Helper::setDate(1, $order['name']); ?></td>
                    <td class="ta_r">
                        <?php
                            echo Catalog::$currency;
                            echo number_format($order['total'], 2);
                        ?>
                    </td>
                    <td class="ta_r">
                        <?php
                            $status = $objOrder->getStatus($order['status']);
                            echo $status['name'];
                        ?>
                    </td>
                    <td class="ta_r">
                        <?php
                            echo $order['payment_status'] != null ?
                                $order['payment_status'] :
                                "Pending";
                        ?>
                    </td>
                    <td class="ta_r">
                        <?php if ($order['status'] == 1) { ?>
                            <a href="/admin/?page=orders&amp;action=remove&amp;id=<?php
                                echo $order['id']; ?>">
                                Remove
                            </a>
                        <?php } else { ?>
                            <span class="inactive">Remove</span>
                        <?php } ?>
                    </td>
                    <td class="ta_r">
                        <a href="/admin/?page=orders&amp;action=edit&amp;id=<?php
                            echo $order['id'];
                        ?>">
                            View
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php echo $objPaging->getPaging(); ?>

    <?php
    } else {
        echo '<p>' . $empty . '</p>';
    }
?>

<?php require_once('templates/_footer.php'); ?>