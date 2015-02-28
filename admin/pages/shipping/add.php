<?php

use \Exception;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Plugin;
use MyECOMM\Country;
use MyECOMM\Helper;

$objForm = new Form();
$objValidation = new Validation($objForm);
$objValidation->expected = ['name', 'local'];
$objValidation->required = ['name'];

try {
    if ($objValidation->isValid()) {
        if ($objShipping->addType($objValidation->post)) {
            $replace = [];
            $urlSort = $this->objUrl->getCurrent(
                ['action', 'id'], false, ['action', 'sort']
            );

            if (!empty($objValidation->post['local'])) {
                $rows = $objShipping->getTypes(1);
                $zones = $objShipping->getZones();
                $replace['#typesLocal'] = Plugin::get('admin'.DS.'shipping', [
                    'rows' => $rows,
                    'zones' => $zones,
                    'objUrl' => $this->objUrl,
                    'urlSort' => $urlSort
                ]);
            } else {
                $rows = $objShipping->getTypes();
                $objCountry = new Country();
                $countries = $objCountry->getAllExceptLocal();
                $replace['#typesInternational'] = Plugin::get('admin'.DS.'shipping', [
                    'rows' => $rows,
                    'countries' => $countries,
                    'objUrl' => $this->objUrl,
                    'urlSort' => $urlSort
                ]);
            }
            echo Helper::json(['error' => false, 'replace' => $replace]);
        } else {
            $objValidation->addToErrors('name', 'Record could not be added.');
            throw new Exception('Record could not be added.');
        }
    } else {
        throw new Exception('Missing parameter.');
    }
} catch (Exception $e) {
    echo Helper::json([
        'error' => true,
        'validation' => $objValidation->errorMessages
    ]);
}

