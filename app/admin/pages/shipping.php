<?php

use \Exception;
use MyECOMM\Login;
use MyECOMM\Shipping;
use MyECOMM\Helper;

// Restrict access only to logged in admin users
Login::restrictAdmin();

// Instantiate shipping
$objShipping = new Shipping();

$id = $this->objUrl->get('id');
$action = $this->objUrl->get('action');

try {
    switch ($action) {
        // Cases that need the id parameter
        case 'default':
        case 'active':
        case 'remove':
        case 'update':
        case 'duplicate':
        case 'rates':
        // Check if the id exists
        if (!empty($id)) {
            // Get the shipping type
            $type = $objShipping->getType($id);
            // Check if the type exists
            if (!empty($type)) {
                switch ($action) {
                    case 'default':
                        require_once('shipping'.DS.'default.php');
                        break;
                    case 'active':
                        require_once('shipping'.DS.'active.php');
                        break;
                    case 'remove':
                        require_once('shipping'.DS.'remove.php');
                        break;
                    case 'update':
                        require_once('shipping'.DS.'update.php');
                        break;
                    case 'duplicate':
                        require_once('shipping'.DS.'duplicate.php');
                        break;
                    case 'rates':
                        require_once('shipping'.DS.'rates.php');
                        break;
                }
            } else {
                throw new Exception('Record not found.');
            }
        } else {
            throw new Exception('Missing parameter.');
        }
        break;
        // Cases that do not need the id parameter
        case 'sort':
            require_once('shipping'.DS.'sort.php');
            break;
        case 'add':
            require_once('shipping'.DS.'add.php');
            break;
        default:
            require_once('shipping'.DS.'list.php');
    }
} catch (Exception $e) {
    echo Helper::json([
            'error' => true,
            'message' => $e->getMessage()
        ]);
}