<?php

use \Exception;
use MyECOMM\Helper;

$call = $this->objUrl->get('call');

try {
    switch ($call) {
        case 'cart':
            require_once(MODULES_PATH.DS.'cart.php');
            break;
        case 'cart-left':
            require_once(MODULES_PATH.DS.'cart-left.php');
            break;
        case 'cart-qty':
            require_once(MODULES_PATH.DS.'cart-qty.php');
            break;
        case 'cart-remove':
            require_once(MODULES_PATH.DS.'cart-remove.php');
            break;
        case 'paypal':
            require_once(MODULES_PATH.DS.'paypal.php');
            break;
        case 'resend':
            require_once(MODULES_PATH.DS.'resend.php');
            break;
        case 'summary-update':
            require_once(MODULES_PATH.DS.'summary-update.php');
            break;
        case 'preload-images':
            require_once(MODULES_PATH.DS.'preload-images.php');
            break;
        case 'wishlist-remove':
            require_once(MODULES_PATH.DS.'wishlist-remove.php');
            break;
        case 'wishlist-add':
            require_once(MODULES_PATH.DS.'wishlist-add.php');
            break;
        default:
            throw new Exception('Invalid request.');
    }
} catch (Exception $e) {
    echo Helper::json(['error' => true, 'message' => $e->getMessage()]);
}