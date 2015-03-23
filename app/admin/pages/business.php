<?php

use MyECOMM\Login;

// Restrict access only for logged in admins
Login::restrictAdmin();

$action = $this->objUrl->get('action');

switch ($action) {
    default:
        require_once('business'.DS.'edit.php');
}