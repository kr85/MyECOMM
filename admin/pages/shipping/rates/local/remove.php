<?php

use \Exception;
use MyECOMM\Plugin;
use MyECOMM\Helper;

$rid = $this->objUrl->get('rid');

if (!empty($rid)) {
    $record = $objShipping->getShippingByIdTypeZone($rid, $id, $zid);

    if (empty($record)) {
        throw new Exception('Record does not exist.');
    }

    if ($objShipping->removeShipping($record['id'])) {
        $shipping = $objShipping->getShippingByTypeZone($id, $zid);
        $replace = [];
        $replace['#shippingList'] = Plugin::get('admin'.DS.'shipping-cost', [
            'rows' => $shipping,
            'objUrl' => $this->objUrl,
            'objCurrency' => $this->objCurrency
        ]);
        echo Helper::json(['error' => false, 'replace' => $replace]);
    } else {
        throw new Exception('Record could not be removed.');
    }
} else {
    throw new Exception('Missing parameter.');
}