<?php

use MyECOMM\User;
use MyECOMM\Order;
use MyECOMM\Helper;
use MyECOMM\Paging;
use MyECOMM\Catalog;

$objUser = new User();
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
        $users = $objUser->getUsers($search);
        $empty = 'There are <strong>no results</strong> matching your search criteria.';

    } else {
        $users = $objUser->getUsers();
        $empty = 'There are <strong>currently</strong> no records.';
    }

    $usersCount = count($users);
    $usersPerPage = 10;
    $objPaging = new Paging($this->objUrl, $users, $usersPerPage);
    $rows = $objPaging->getRecords();
    $usersOnPage = count($rows);
    $page = $this->objUrl->get('pg');
    $page = (empty($page)) ? 1 : intval($page);

    require_once('_header.php'); ?>

<div class="listing user-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Clients
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Clients</h1>
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
                            <label for="search"> Name: </label>
                        </th>
                        <td>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="<?php echo $search; ?>"
                                class="fld"
                                placeholder="Find clients..."
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
                    <span class="nobr">Client Name</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Edit Client</span>
                </th>
                <th class="center" rowspan="1">
                    <span class="nobr">Remove Client</span>
                </th>
            </tr>
            <?php foreach ($rows as $user): ?>
            <tr>
                <td class="center">
                    <?php echo Helper::encodeHTML(
                        $user['first_name']." ".$user['last_name']
                    ); ?>
                </td>
                <td class="center">
                    <a
                        href="<?php echo $this->objUrl->getCurrent(
                            ['action','id'],
                            false,
                            ['action', 'edit', 'id', $user['id']]) ?>"
                        class="btn-edit-2"
                        title="Edit Client"
                    >
                        Edit
                    </a>
                </td>
                <td class="center">
                    <?php
                    $orders = $objOrder->getClientOrders($user['id']);
                    if (empty($orders)): ?>
                        <a
                            href="<?php echo $this->objUrl->getCurrent(
                                ['action','id'],
                                false,
                                ['action', 'remove', 'id', $user['id']]); ?>"
                            class="btn-remove-2"
                            title="Remove Client"
                        >
                            Remove
                        </a>
                    <?php else: ?>
                        <span
                            class="btn-remove-2"
                            title="Can't Remove Active Client"
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
                    $page, $usersCount, $usersPerPage, $usersOnPage
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
                <?php if ($usersCount != 0): ?>
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