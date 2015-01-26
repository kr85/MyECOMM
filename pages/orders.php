<?php

    // Restrict access only for logged in users
    Login::restrictFront();
    $objOrder = new Order();
    $orders = $objOrder->getClientOrders(Session::getSession(Login::$loginFront));
    $objPaging = new Paging($orders, 5);
    $rows = $objPaging->getRecords();
    require_once('_header.php');
?>

    <h1>My Orders</h1>

<?php
    if (!empty($rows)) {
        ?>
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
            <tr>
                <th>Id</th>
                <th class="ta_r">Date</th>
                <th class="ta_r col_15">Status</th>
                <th class="ta_r col_15">Total</th>
                <th class="ta_r col_15">Invoice</th>
            </tr>

            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td class="ta_r">
                        <?php
                            echo Helper::setDate(1, $row['date']);
                        ?>
                    </td>
                    <td class="ta_r">
                        <?php
                            $status = $objOrder->getStatus($row['status']);
                            echo $status['name'];
                        ?>
                    </td>
                    <td class="ta_r">
                        <?php
                            echo Catalog::$currency;
                            echo number_format($row['total'], 2);
                        ?>
                    </td>
                    <td class="ta_r">
                        <?php
                            if ($row['pp_status'] == 1) {
                                ?>
                                <a href="/?page=invoice&amp;id=<?php echo $row['id']; ?>"
                                   target="_blank">
                                    Invoice
                                </a>
                            <?php
                            }
                            else {
                                ?>
                                <span class="inactive">Invoice</span>
                            <?php
                            }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php echo $objPaging->getPaging(); ?>
    <?php
    }
    else {
        ?>
        <p>You do not have any orders.</p>
    <?php
    }
?>

<?php require_once('_footer.php'); ?>