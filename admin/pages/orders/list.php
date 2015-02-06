<?php

    $objOrder = new Order();

    if (isset($_POST['search'])) {
        if (!empty($_POST['search'])) {
            $url = $this->objUrl->getCurrent('search') . '/search/' . urlencode(
                    stripslashes($_POST['search'])
                );
        } else {
            $url = $this->objUrl->getCurrent('search');
        }
        Helper::redirect($url);
    } else {
        $search = stripslashes(urldecode($this->objUrl->get('search')));

        if (!empty($search)) {
            $orders = $objOrder->getAllOrders($search);
            $empty = 'There are no results matching your search criteria.';
        } else {
            $orders = $objOrder->getAllOrders();
            $empty = 'There are currently no records.';
        }

        $objPaging = new Paging($this->objUrl, $orders, 5);
        $rows = $objPaging->getRecords();

        require_once('_header.php'); ?>

        <h1>Orders</h1>

        <form action="<?php echo $this->objUrl->getCurrent('search'); ?>"
              method="POST">
            <table cellspacing="0" cellpadding="0" border="0"
                   class="tbl_insert">
                <tr>
                    <th>
                        <label for="search"> Order No.: </label>
                    </th>
                    <td>
                        <input type="text" name="search" id="search"
                               value="<?php echo $search; ?>" class="fld"/>
                    </td>
                    <td>
                        <label for="btn_add" class="sbm sbm_blue fl_l"> <input
                                type="submit" id="btn_add" class="btn"
                                value="Search"/> </label>
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (!empty($rows)) {
            ?>
            <table cellpadding="0" cellspacing="0" border="0"
                   class="tbl_repeat">
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
                        <td><?php echo Helper::setDate(
                                1,
                                $order['name']
                            ); ?></td>
                        <td class="ta_r">
                            <?php
                                echo Catalog::$currency;
                                echo number_format($order['total'], 2);
                            ?>
                        </td>
                        <td class="ta_r">
                            <?php
                                $status = $objOrder->getStatus(
                                    $order['status']
                                );
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
                                <a href="<?php echo $this->objUrl->getCurrent(
                                        'action'
                                    ) . '/action/remove/id/' . $order['id']; ?>">
                                    Remove </a>
                            <?php } else { ?>
                                <span class="inactive">Remove</span>
                            <?php } ?>
                        </td>
                        <td class="ta_r">
                            <a href="<?php echo $this->objUrl->getCurrent(
                                    'action'
                                ) . '/action/edit/id/' . $order['id']; ?>">
                                View </a>
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

        <?php require_once('_footer.php');
    }
?>