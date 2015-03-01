<?php

use MyECOMM\Catalog;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Basket;

    // Result array
    $out = [];

    // Check if job and id are set
    if (isset($_POST['job']) && isset($_POST['id'])) {

        // Store job and id
        $job = $_POST['job'];
        $id = $_POST['id'];

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
                    Session::setItem($id);
                    $out['job'] = 0;
                    break;
            }

            $objBasket = (is_object($objBasket)) ? $objBasket : new Basket();

            $out['replace_values']['.bl_ti'] = $objBasket->numberOfItems;
            $out['replace_values']['.bl_st'] = $this->objCurrency->display(
                number_format($objBasket->subTotal, 2)
            );

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