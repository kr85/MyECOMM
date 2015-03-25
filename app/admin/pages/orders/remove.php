<?php

use MyECOMM\Order;
use MyECOMM\Helper;
use MyECOMM\Paging;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objOrder = new Order();
    $order = $objOrder->getOrder($id);

    if (!empty($order)) {

        $yes = $this->objUrl->getCurrent().'/remove/1';
        $no = 'javascript:history.go(-1)';

        $remove = $this->objUrl->get('remove');

        if (!empty($remove)) {
            $objOrder->removeOrder($id);
            Helper::redirect(
                $this->objUrl->getCurrent([
                    'action',
                    'id',
                    'remove',
                    'search',
                    Paging::$key
                ])
            );
        }

        require_once('_header.php'); ?>

        <div class="listing product-list">
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
                            Remove
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="page-title">
                <h1>Orders :: Remove</h1>
            </div>
            <p class="remove-yes-no">
                Are you sure you want to remove this order?
                <a href="<?php echo $yes; ?>">Yes</a> |
                <a href="<?php echo $no; ?>">No</a>
            </p>
        </div>

        <?php require_once('_footer.php');
    }
}
?>