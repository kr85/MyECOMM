<?php

use \Exception;
use MyECOMM\Helper;

if ($objShipping->removeType($type['id'])) {
    echo Helper::json(['error' => false]);
} else {
    throw new Exception('Record could not be removed.');
}