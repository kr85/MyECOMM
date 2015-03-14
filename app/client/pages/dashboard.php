<?php

use MyECOMM\Login;

// Restrict access only for logged in users
Login::restrictFront($this->objUrl);

require_once('_header.php'); ?>

<?php require_once('_footer.php'); ?>