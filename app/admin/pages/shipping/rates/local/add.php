<?php

use \Exception;
use MyECOMM\Form;
use MyECOMM\Validation;
use MyECOMM\Plugin;
use MyECOMM\Helper;

$objForm = new Form();
$objValidation = new Validation($objForm);
$objValidation->expected = ['weight', 'cost'];
$objValidation->required = ['weight', 'cost'];

try {
    if ($objValidation->isValid()) {
        if ($objShipping->isDuplicateLocal($id, $zid, $objValidation->post['weight'])) {
            $objValidation->addToErrors('weight', 'Duplicate weight.');
            throw new Exception('Duplicate weight.');
        }

        $objValidation->post['type'] = $id;
        $objValidation->post['zone'] = $zid;
        $objValidation->post['country'] = COUNTRY_LOCAL;

        if ($objShipping->addShipping($objValidation->post)) {
            $shipping = $objShipping->getShippingByTypeZone($id, $zid);
            $replace = [];
            $replace['#shippingList'] = Plugin::get('admin'.DS.'shipping-cost', [
                'rows' => $shipping,
                'objUrl' => $this->objUrl,
                'objCurrency' => $this->objCurrency
            ]);
            echo Helper::json(['error' => false, 'replace' => $replace]);
        } else {
            $objValidation->addToErrors('weight', 'Record could not be added.');
            throw new Exception('Record could not be added.');
        }
    } else {
        throw new Exception('Invalid request.');
    }
} catch (Exception $e) {
    echo Helper::json([
        'error' => true,
        'validation' => $objValidation->errorMessages
    ]);
}