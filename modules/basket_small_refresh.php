<?php

    require_once("../includes/config.php");

    // Instantiate basket class
    //$objBasket = is_object($objBasket) ? $objBasket : new Basket();
    $objBasket = new Basket();
    $out = [];
    $out['bl_ti'] = $objBasket->numberOfItems;
    $out['bl_st'] = number_format($objBasket->subTotal, 2);

    echo Helper::json($out);