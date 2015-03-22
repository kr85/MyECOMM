<?php

use MyECOMM\Login;

// Restrict access only for logged in admins
Login::restrictAdmin();

$action = $this->objUrl->get('action');

switch ($action) {
    case 'add':
        require_once('categories'.DS.'add.php');
        break;
    case 'edit':
        require_once('categories'.DS.'edit.php');
        break;
    case 'remove':
        require_once('categories'.DS.'remove.php');
        break;
    default:
        require_once('categories'.DS.'list.php');
}