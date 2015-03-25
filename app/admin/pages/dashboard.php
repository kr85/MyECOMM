<?php

use MyECOMM\Login;
use MyECOMM\Admin;
use MyECOMM\Session;
use MyECOMM\Business;
use MyECOMM\Country;

Login::restrictAdmin();

$objAdmin = new Admin();
$adminName = $objAdmin->getFullNameAdmin(Session::getSession(Login::$loginAdmin));

$objBusiness = new Business();
$business = $objBusiness->getOne(Business::BUSINESS_ID);

$objCountry = new Country();
$businessCountry = $objCountry->getOne($business['country']);

require_once('_header.php'); ?>

<div class="listing dashboard">
    <div class="breadcrumbs">
        <ul>
            <li>
                <strong>
                    Dashboard
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Dashboard</h1>
    </div>
    <div class="welcome-msg">
        <p class="hello">
            <strong>
                Hello,
                <?php echo $adminName; ?>
            </strong>
        </p>
        <p>
            From the Dashboard you have the ability to view a
            snapshot of clients recent account activities, edit client's
            information, review and update orders, as well as manage sections,
            categories, products, shipping types, rates and much more.
        </p>
    </div>
    <div class="box-account box-info">
        <div class="box-head">
            <h2>Business Information</h2>
        </div>
        <div class="box">
            <div class="box-title">
                <h3>Business Details</h3>
            </div>
            <div class="box-content">
                <p>
                    <strong><?php echo $business['name']; ?></strong><br/>
                    <?php echo nl2br($business['address']); ?><br/>
                    <?php echo $businessCountry['name']; ?><br/>
                    <?php echo $business['telephone']; ?><br/>
                    <?php echo $business['email']; ?><br/>
                    <?php echo $business['website']; ?><br/>
                    <a href="<?php echo $this->objUrl->href('panel/business'); ?>">
                        Edit Details
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once('_footer.php'); ?>