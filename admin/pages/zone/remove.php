<?php

use \Exception;
use MyECOMM\Helper;

if ($objShipping->removeZone($zone['id'])) {
    echo Helper::json(['error' => false]);
} else {
    throw new Exception('Record could not be removed.');
}