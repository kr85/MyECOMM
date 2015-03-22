<?php

use MyECOMM\Login;

// Restrict access only for logged in admins
Login::restrictAdmin();

$action = $this->objUrl->get('action');

switch ($action) {
    case 'add':
        require_once('sections'.DS.'add.php');
        break;
    case 'edit':
        require_once('sections'.DS.'edit.php');
        break;
    case 'remove':
        require_once('sections'.DS.'remove.php');
        break;
    default:
        require_once('sections'.DS.'list.php');
}