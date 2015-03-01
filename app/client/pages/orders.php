<?php

use MyECOMM\Login;
use MyECOMM\Order;
use MyECOMM\Session;
use MyECOMM\Paging;
use MyECOMM\Helper;

// Restrict access only for logged in users
Login::restrictFront($this->objUrl);
$objOrder = new Order();
$orders = $objOrder->getClientOrders(
    Session::getSession(Login::$loginFront)
);
$objPaging = new Paging($this->objUrl, $orders, 5);
$rows = $objPaging->getRecords();

require_once('_header.php');
?>

<h1>My Orders</h1>

<?php if (!empty($rows)): ?>
<table class="tbl_repeat">
    <thead>
        <tr>
            <th>Id</th>
            <th class="ta_r">Date</th>
            <th class="ta_r col_15">Status</th>
            <th class="ta_r col_15">Total</th>
            <th class="ta_r col_15">Invoice</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
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
                    echo $this->objCurrency->display(
                        number_format($row['total'], 2)
                    );
                ?>
            </td>
            <td class="ta_r">
                <?php if ($row['pp_status'] == 1): ?>
                    <a href="<?php echo $this->objUrl->href(
                        'invoice', [
                            'token',
                            $row['token']
                        ]
                    ); ?>" target="_blank">Invoice</a>
                <?php else: ?>
                    <span class="inactive">Invoice</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php echo $objPaging->getPaging(); ?>
<?php else: ?>
<p>You do not have any orders.</p>
<?php endif;
require_once('_footer.php');
?>