<?php

use MyECOMM\Login;

// Restrict access only for logged in admins
Login::restrictAdmin();

$action = $this->objUrl->get('action');

switch ($action) {
    case 'edit':
        require_once('orders'.DS.'edit.php');
        break;
    case 'invoice':
        require_once('orders'.DS.'invoice.php');
        break;
    case 'remove':
        require_once('orders'.DS.'remove.php');
        break;
    default:
        require_once('orders'.DS.'list.php');
}