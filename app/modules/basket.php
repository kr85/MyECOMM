<?php

use MyECOMM\Catalog;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Basket;
use MyECOMM\Plugin;

// Result array
$out = [];

// Check if job and id are set
if (isset($_POST['job']) && isset($_POST['id'])) {

    // Store job and id
    $job = $_POST['job'];
    $id = $_POST['id'];

    if (isset($_POST['qty'])) {
        $qty = $_POST['qty'];
    } else {
        $qty = 1;
    }

    // Instantiate catalog class
    $objCatalog = new Catalog();
    $product = $objCatalog->getProduct($id);

    if (!empty($product)) {
        switch ($job) {
            case 0:
                Session::removeItem($id);
                $out['job'] = 1;
                break;
            case 1:
                Session::setItem($id, $qty);
                $out['job'] = 0;
                break;
        }

        $objBasket = (is_object($objBasket)) ? $objBasket : new Basket();

        $out['replace_values']['.bl_ti'] = $objBasket->numberOfItems;
        $out['replace_values']['.bl_st'] = $this->objCurrency->display(
            number_format($objBasket->subTotal, 2)
        );

        if ($objBasket->numberOfItems == 1) {
            $summaryAmount = 'There is <a href="'.
                $this->objUrl->href('basket').'">'.
                $objBasket->numberOfItems.
                ' item</a> in your cart';
        } else {
            $summaryAmount = 'There are <a href="'.
                $this->objUrl->href('basket').'">'.
                $objBasket->numberOfItems.
                ' items</a> in your cart';
        }

        Session::setSession('summaryAmount', $summaryAmount);

        $out['replace_values']['#my-cart-small'] = Plugin::get('front'.DS.'basket_left', [
            'objUrl' => $this->objUrl,
            'objCurrency' => $this->objCurrency,
            'objCatalog' => $objCatalog,
            'summaryAmount' => $summaryAmount
        ]);

        $out['error'] = false;
        echo Helper::json($out);
    } else {
        $out['error'] = true;
        echo Helper::json($out);
    }
} else {
    $out['error'] = true;
    echo Helper::json($out);
}