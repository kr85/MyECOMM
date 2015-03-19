<?php

use MyECOMM\Form;
use MyECOMM\Catalog;
use MyECOMM\Session;
use MyECOMM\Basket;
use MyECOMM\Helper;
use MyECOMM\Plugin;

$objForm = new Form();

$array = $objForm->getPostArray();

if (!empty($array)) {

    $objCatalog = new Catalog();

    foreach ($array as $key => $value) {

        $identity = explode('-', $key);

        if (count($identity) == 2 && $identity[0] == 'qty') {

            $product = $objCatalog->getProduct($identity[1]);

            if (empty($product)) {
                continue;
            }

            if (empty($value)) {
                Session::removeItem($product['id']);
            } else {
                Session::setItem($product['id'], $value);
            }
        }
    }

    $objBasket = (is_object($objBasket)) ? $objBasket : new Basket();

    $out['replace_values']['.bl_ti'] = $objBasket->numberOfItems;
    $out['replace_values']['.bl_st'] = $this->objCurrency->display(
        number_format($objBasket->subTotal, 2)
    );

    $out['replace_values']['#main_basket'] = Plugin::get('front'.DS.'cart_view', [
        'objUrl' => $this->objUrl,
        'objCurrency' => $this->objCurrency
    ]);

    $out['message'] = 'Shopping cart was successfully updated.';
    echo Helper::json($out);
}
