<?php

use MyECOMM\Login;

// Restrict access only for logged in admins
Login::restrictAdmin();

$action = $this->objUrl->get('action');

switch ($action) {
    case 'add':
        require_once('products'.DS.'add.php');
        break;
    case 'edit':
        require_once('products'.DS.'edit.php');
        break;
    case 'remove':
        require_once('products'.DS.'remove.php');
        break;
    default:
        require_once('products'.DS.'list.php');
}