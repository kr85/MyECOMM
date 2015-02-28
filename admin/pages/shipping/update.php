<?php

use \Exception;
use MyECOMM\Form;
use MyECOMM\Helper;

$objForm = new Form();
$value = $objForm->getPost('value');

if (!empty($value)) {
    if ($objShipping->updateType(['name' => $value], $type['id'])) {
        echo Helper::json(['error' => false]);
    } else {
        throw new Exception('Record could not be updated.');
    }
} else {
    throw new Exception('Invalid entry.');
}