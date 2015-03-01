<?php

use MyECOMM\Session;
use MyECOMM\Basket;
use MyECOMM\Helper;
use MyECOMM\Plugin;

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    Session::removeItem($id);
}

$objBasket = (is_object($objBasket)) ? $objBasket : new Basket();

$out = [];
$out['replace_values']['.bl_ti'] = $objBasket->numberOfItems;
$out['replace_values']['.bl_st'] = $this->objCurrency->display(
    number_format($objBasket->subTotal, 2)
);
$out['replace_values']['#main_basket'] = Plugin::get('front'.DS.'basket_view', [
    'objUrl' => $this->objUrl,
    'objCurrency' => $this->objCurrency
]);

echo Helper::json($out);