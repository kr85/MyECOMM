<?php

use MyECOMM\Login;
use MyECOMM\Order;
use MyECOMM\Session;
use MyECOMM\Paging;
use MyECOMM\Helper;
use MyECOMM\Plugin;
use MyECOMM\Catalog;

// Restrict access only for logged in users
Login::restrictFront($this->objUrl);
$objOrder = new Order();
$orders = $objOrder->getClientOrders(
    Session::getSession(Login::$loginFront)
);
$productsCount = count($orders);
$productsPerPage = 10;
$objPaging = new Paging($this->objUrl, $orders, $productsPerPage);
$rows = $objPaging->getRecords();
$productsOnPage = count($rows);
$page = $this->objUrl->get('pg');
$page = (empty($page)) ? 1 : intval($page);
$objCatalog = new Catalog();

require_once('_header.php');
?>

    <div class="main pad-bottom">
        <div class="col-main orders">
            <?php if (!empty($rows)): ?>
            <div class="page-title">
                <h1>My Orders</h1>
            </div>
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
            <fieldset>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="center" rowspan="1">
                                <span class="nobr">Order Id</span>
                            </th>
                            <th class="center" rowspan="1">
                                <span class="nobr">Date</span>
                            </th>
                            <th class="center">
                                <span class="nobr">Status</span>
                            </th>
                            <th class="center">
                                <span class="nobr">Total</span>
                            </th>
                            <th class="center">
                                <span class="nobr">Invoice</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td class="center">
                                    <span>
                                        <?php echo $row['id']; ?>
                                    </span>
                                </td>
                                <td class="center">
                                    <span>
                                    <?php
                                        echo Helper::setDate(1, $row['date']);
                                    ?>
                                    </span>
                                </td>
                                <td class="center">
                                    <span>
                                    <?php
                                        $status = $objOrder->getStatus($row['status']);
                                        echo $status['name'];
                                    ?>
                                    </span>
                                </td>
                                <td class="center">
                                    <span class="regular-price">
                                        <span class="price">
                                        <?php
                                            echo $this->objCurrency->display(
                                                number_format($row['total'], 2)
                                            );
                                        ?>
                                        </span>
                                    </span>
                                </td>
                                <td class="center">
                                    <?php if ($row['pp_status'] == 1): ?>
                                    <a
                                        href="<?php echo $this->objUrl->href('invoice', [
                                            'token',
                                            $row['token']
                                        ]); ?>"
                                        target="_blank"
                                        >
                                        Invoice
                                    </a>
                                    <?php else: ?>
                                    <span class="inactive">Invoice</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
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
                <div class="center">
                    <div class="page-title">
                        <h1>My Orders</h1>
                    </div>
                    <p class="empty">
                        You have <strong>no orders</strong> at this time.<br/>
                        Click <a href="/">here</a> to continue shopping.
                    </p>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-right sidebar">
            <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
                'objUrl'        => $this->objUrl,
                'objCurrency'   => $this->objCurrency,
                'objNavigation' => $this->objNavigation,
                'objCatalog'    => $objCatalog,
                'listing'       => 'category',
                'id'            => 0,
                'productId'     => 0,
                'dashboard'     => true
            ]); ?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php require_once('_footer.php'); ?>