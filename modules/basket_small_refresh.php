<?php

require_once("../includes/autoload.php");

// Instantiate basket class
$objBasket = new Basket();

$out = [];

$out['bl_ti'] = $objBasket->numberOfItems;
$out['bl_st'] = number_format($objBasket->subTotal, 2);
$out['bl_vat'] = number_format($objBasket->tax, 2);
$out['bl_total'] = number_format($objBasket->total, 2);

echo json_encode($out);