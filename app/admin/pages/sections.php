<?php

use MyECOMM\Login;

// Restrict access only for logged in admins
Login::restrictAdmin();

$action = $this->objUrl->get('action');

switch ($action) {
    case 'add':
        require_once('categories' . DS . 'add.php');
        break;
    case 'added':
        require_once('sections'.DS.'added.php');
        break;
    case 'added-failed':
        require_once('sections'.DS.'added-failed.php');
        break;
    case 'edit':
        require_once('sections'.DS.'edit.php');
        break;
    case 'edited':
        require_once('sections'.DS.'edited.php');
        break;
    case 'edited-failed':
        require_once('sections'.DS.'edited-failed.php');
        break;
    case 'remove':
        require_once('sections'.DS.'remove.php');
        break;
    default:
        require_once('sections'.DS.'list.php');
}