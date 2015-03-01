<?php

use \Exception;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Helper;
use MyECOMM\Plugin;

$objForm = new Form();
$objValidation = new Validation($objForm);
$objValidation->expected = ['name'];
$objValidation->required = ['name'];

try {
    if ($objValidation->isValid()) {
        if ($objShipping->addZone($objValidation->post)) {
            $zones = $objShipping->getZones();
            $replace = [];
            $replace['#zoneList'] = Plugin::get('admin'.DS.'zone', [
                'rows' => $zones,
                'objUrl' => $this->objUrl
            ]);
            echo Helper::json(['error' => false, 'replace' => $replace]);
        } else {
            $objValidation->addToErrors('name', 'Record could not be added.');
            throw new Exception('Record could not be added.');
        }
    } else {
        throw new Exception('Invalid entry.');
    }
} catch (Exception $e) {
    echo Helper::json(['error' => true, 'validation' => $e->getMessage()]);
}