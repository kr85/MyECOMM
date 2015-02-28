<?php

use \Exception;
use MyECOMM\Plugin;
use MyECOMM\Helper;

if ($objCountry->delete($country['id'])) {
    $countries = $objCountry->getAll();
    $replace['#countryList'] = Plugin::get('admin'.DS.'country', [
        'rows' => $countries,
        'objUrl' => $this->objUrl
    ]);
    echo Helper::json(['error' => false, 'replace' => $replace]);
} else {
    throw new Exception('Record could not be removed.');
}