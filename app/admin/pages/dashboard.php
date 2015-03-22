<?php

use MyECOMM\Login;

Login::restrictAdmin();

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
</div>

<?php require_once('_footer.php'); ?>