<?php

use \Exception;
use MyECOMM\Helper;

$call = $this->objUrl->get('call');

try {
    switch ($call) {
        case 'basket':
            require_once(MODULES_PATH.DS.'basket.php');
            break;
        case 'basket-left':
            require_once(MODULES_PATH.DS.'basket-left.php');
            break;
        case 'basket-qty':
            require_once(MODULES_PATH.DS.'basket-qty.php');
            break;
        case 'basket-remove':
            require_once(MODULES_PATH.DS.'basket-remove.php');
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
        default:
            throw new Exception('Invalid request.');
    }
} catch (Exception $e) {
    echo Helper::json(['error' => true, 'message' => $e->getMessage()]);
}