<?php

use MyECOMM\User;
use MyECOMM\Order;
use MyECOMM\Helper;
use MyECOMM\Paging;

$objUser = new User();
$objOrder = new Order();

if (isset($_POST['search'])) {
    if (!empty($_POST['search'])) {
        $url = $this->objUrl->getCurrent('search').'/search/'.urlencode(
                stripslashes($_POST['search'])
            );
    } else {
        $url = $this->objUrl->getCurrent('search');
    }
    Helper::redirect($url);
} else {
    $search = stripslashes(urldecode($this->objUrl->get('search')));
    if (!empty($search)) {
        $users = $objUser->getUsers($search);
        $empty = 'There are no results matching your search criteria.';

    } else {
        $users = $objUser->getUsers();
        $empty = 'There are currently no records.';
    }

    $objPaging = new Paging($this->objUrl, $users, 5);
    $rows = $objPaging->getRecords();

    require_once('_header.php'); ?>

    <h1>Clients</h1>

    <form action="<?php echo $this->objUrl->getCurrent('search'); ?>"
          method="POST">
        <table class="tbl_insert">
            <tr>
                <th>
                    <label for="search"> Name: </label>
                </th>
                <td>
                    <input type="text" name="search" id="search"
                           value="<?php echo $search; ?>" class="fld"/>
                </td>
                <td>
                    <label for="btn_add" class="sbm sbm_blue fl_l">
                        <input type="submit" id="btn_add" class="btn" value="Search"/>
                    </label>
                </td>
            </tr>
        </table>
    </form>

    <?php if (!empty($rows)): ?>
        <table class="tbl_repeat">
            <tr>
                <th>Name</th>
                <th class="ta_r col_15">Remove</th>
                <th class="ta_r col_15">Edit</th>
            </tr>
            <?php foreach ($rows as $user): ?>
                <tr>
                    <td>
                        <?php echo Helper::encodeHTML(
                            $user['first_name']." ".$user['last_name']
                        ); ?>
                    </td>
                    <td class="ta_r">
                        <?php
                            $orders = $objOrder->getClientOrders($user['id']);
                            if (empty($orders)) { ?>
                                <a href="<?php echo $this->objUrl->getCurrent([
                                        'action',
                                        'id'
                                    ]).'/action/remove/id/'.$user['id']; ?>">
                                    Remove
                                </a>
                            <?php } else { ?>
                                <span class="inactive">Remove</span>
                            <?php } ?>
                    </td>
                    <td class="ta_r">
                        <a href="<?php echo $this->objUrl->getCurrent([
                                'action',
                                'id'
                            ]).'/action/edit/id/'.$user['id']; ?>">
                            Edit
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php echo $objPaging->getPaging(); ?>

    <?php else:
        echo '<p>'.$empty.'</p>';
    endif; ?>

    <?php require_once('_footer.php');
}
?>