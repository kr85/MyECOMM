<?php

use MyECOMM\Order;
use MyECOMM\Helper;
use MyECOMM\Paging;
use MyECOMM\Catalog;

$objOrder = new Order();
$objCatalog = new Catalog();

if (isset($_POST['search'])):
    if (!empty($_POST['search'])) {
        $url = $this->objUrl->getCurrent('search').'/search/'.urlencode(
                stripslashes($_POST['search'])
            );
    } else {
        $url = $this->objUrl->getCurrent('search');
    }
    Helper::redirect($url);
else:
    $search = stripslashes(urldecode($this->objUrl->get('search')));

    if (!empty($search)) {
        $orders = $objOrder->getAllOrders($search);
        $empty = 'There are <strong>no results</strong> matching your search criteria.';
    } else {
        $orders = $objOrder->getAllOrders();
        $empty = 'There are <strong>currently</strong> no records.';
    }

    $productsCount = count($orders);
    $productsPerPage = 10;
    $objPaging = new Paging($this->objUrl, $orders, $productsPerPage);
    $rows = $objPaging->getRecords();
    $productsOnPage = count($rows);
    $page = $this->objUrl->get('pg');
    $page = (empty($page)) ? 1 : intval($page);

    require_once('_header.php'); ?>

<div class="listing order-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Orders
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Orders</h1>
    </div>
    <div class="row">
        <div class="search-form-box">
            <form
                action="<?php echo $this->objUrl->getCurrent('search'); ?>"
                method="POST"
            >
                <table>
                    <tr>
                        <th>
                            <label for="search"> Order No.: </label>
                        </th>
                        <td>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="<?php echo $search; ?>"
                                class="fld"
                                placeholder="Find orders..."
                            />
                        </td>
                        <td>
                            <button class="button" type="submit">
                                <span>
                                    <span>Search</span>
                                </span>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php if (!empty($rows)): ?>
    <fieldset>
        <table class="data-table">
            <tr>
                <th class="center" rowspan="1">
                    <span class="nobr">Order Id</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Date</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Total</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Status</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">PayPal Status</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">View</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Remove</span>
                </th>
            </tr>
            <?php foreach ($rows as $order): ?>
            <tr>
                <td class="center">
                    <?php echo $order['id']; ?>
                </td>
                <td class="center">
                    <?php echo Helper::setDate(1, $order['name']); ?>
                </td>
                <td class="center">
                    <?php
                        echo $this->objCurrency->display(
                            number_format($order['total'], 2)
                        );
                    ?>
                </td>
                <td class="center">
                    <?php
                        $status = $objOrder->getStatus($order['status']);
                        echo $status['name'];
                    ?>
                </td>
                <td class="center">
                    <?php
                        echo $order['payment_status'] != null ?
                            $order['payment_status'] :
                            "Pending";
                    ?>
                </td>
                <td class="center">
                    <a
                        href="<?php echo $this->objUrl->getCurrent(
                            ['action'],
                            false,
                            ['action', 'edit', 'id', $order['id']]
                        ); ?>"
                        class="btn-view"
                        title="View Order"
                    >
                        View
                    </a>
                </td>
                <td class="center">
                    <?php if ($order['status'] == 1): ?>
                        <a
                            href="<?php echo $this->objUrl->getCurrent(
                                ['action'],
                                false,
                                ['action', 'remove', 'id', $order['id']]
                            ); ?>"
                            class="btn-remove-2"
                            title="Remove Order"
                        >
                            Remove
                        </a>
                    <?php else: ?>
                        <span
                            class="inactive btn-remove-2"
                            title="Can't Remove This Order"
                        >
                            Remove
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>
    <div class="toolbar">
        <div class="pager">
            <p class="amount">
                <?php
                echo $objCatalog->getPagerAmountText(
                    $page, $productsCount, $productsPerPage, $productsOnPage
                );
                ?>
            </p>
            <div class="page-number">
                <label for="page-num"><strong>Page: </strong></label>
                <div class="input-box">
                    <input
                        id="page-num"
                        onfocus="this.blur()"
                        type="text"
                        value="<?php echo $page; ?>"
                        readonly="readonly"
                        />
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="pages">
                <?php if ($productsCount != 0): ?>
                    <?php echo $objPaging->getPaging(); ?>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="center pad-top-bottom-30">
            <p class="empty">
                <?php echo $empty; ?>
            </p>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php require_once('_footer.php'); ?>