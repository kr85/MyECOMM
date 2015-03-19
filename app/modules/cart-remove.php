<?php

use MyECOMM\Session;
use MyECOMM\Basket;
use MyECOMM\Helper;
use MyECOMM\Plugin;
use MyECOMM\Catalog;

$objCatalog = new Catalog();

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

$out['replace_values']['#main_basket'] = Plugin::get('front'.DS.'cart_view', [
    'objUrl' => $this->objUrl,
    'objCurrency' => $this->objCurrency
]);

if ($objBasket->numberOfItems == 1) {
    $summaryAmount = 'There is <a href="'.
        $this->objUrl->href('cart').'">'.
        $objBasket->numberOfItems.
        ' item</a> in your cart';
} else {
    $summaryAmount = 'There are <a href="'.
        $this->objUrl->href('cart').'">'.
        $objBasket->numberOfItems.
        ' items</a> in your cart';
}

Session::setSession('summaryAmount', $summaryAmount);

$out['replace_values']['#my-cart-small'] = Plugin::get('front'.DS.'cart_left', [
    'objUrl' => $this->objUrl,
    'objCurrency' => $this->objCurrency,
    'objCatalog' => $objCatalog,
    'summaryAmount' => $summaryAmount
]);

$out['message'] = 'Product was successfully removed from your shopping cart.';
echo Helper::json($out);