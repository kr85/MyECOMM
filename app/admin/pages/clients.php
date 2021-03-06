<?php

use MyECOMM\Login;

// Restrict access only for logged in admins
Login::restrictAdmin();

$action = $this->objUrl->get('action');

switch ($action) {
    case 'edit':
        require_once('clients'.DS.'edit.php');
        break;
    case 'remove':
        require_once('clients'.DS.'remove.php');
        break;
    default:
        require_once('clients'.DS.'list.php');
}