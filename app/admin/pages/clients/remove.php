<?php

use MyECOMM\User;
use MyECOMM\Order;
use MyECOMM\Helper;
use MyECOMM\Paging;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objUser = new User();
    $user = $objUser->getUser($id);

    if (!empty($user)) {

        $objOrder = new Order();
        $orders = $objOrder->getClientOrders($id);

        if (empty($orders)) {
            $yes = $this->objUrl->getCurrent().'/remove/1';
            $no = 'javascript:history.go(-1)';

            $remove = $this->objUrl->get('remove');

            if (!empty($remove)) {
                $objUser->removeUser($id);

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

            <div class="listing client-list">
                <div class="breadcrumbs">
                    <ul>
                        <li class="dashboard">
                            <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                            <span>&nbsp;</span>
                        </li>
                        <li class="clients">
                            <a href="/panel/clients" title="Go to Clients">Clients</a>
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
                    <h1>Clients :: Remove</h1>
                </div>
                <p class="remove-yes-no">
                    Are you sure you want to remove this client (<?php
                        echo $user['first_name']." ".$user['last_name'];
                    ?>)?
                    <a href="<?php echo $yes; ?>">Yes</a> |
                    <a href="<?php echo $no; ?>">No</a>
                </p>
            </div>

            <?php require_once('_footer.php');
        }
    }
}
?>