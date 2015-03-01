<?php

use \Exception;
use MyECOMM\Login;
use MyECOMM\Country;
use MyECOMM\Helper;

Login::restrictAdmin();

$objCountry = new Country();

$id = $this->objUrl->get('id');
$action = $this->objUrl->get('action');

try {
    switch ($action) {
        case 'active':
        case 'remove':
        case 'update':
        if (!empty($id)) {
            $country = $objCountry->getOne($id);
            if (!empty($country)) {
                switch ($action) {
                    case 'active':
                        require_once('country' . DS . 'active.php');
                        break;
                    case 'remove':
                        require_once('country' . DS . 'remove.php');
                        break;
                    case 'update':
                        require_once('country' . DS . 'update.php');
                        break;
                }
            } else {
                throw new Exception('Record could not be found.');
            }
        } else {
            throw new Exception('Missing parameter.');
        }
            break;
        case 'add':
            require_once('country' . DS . 'add.php');
            break;
        default:
            require_once('country' . DS . 'list.php');
    }
} catch (Exception $e) {
    echo Helper::json(['error' => true, 'message' => $e->getMessage()]);
}