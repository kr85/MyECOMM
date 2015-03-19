<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Plugin;

$objCatalog = new Catalog();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $result = $objCatalog->removeProductFromWishlist($id);
    if (!$result) {
        Helper::redirect($this->objUrl->href('error'));
    }
}

$out = [];
$out['replace_values']['#main_wishlist'] = Plugin::get('front'.DS.'wishlist_view', [
    'objUrl' => $this->objUrl,
    'objCurrency' => $this->objCurrency
]);

$out['message'] = 'Product was successfully removed from your wishlist.';
echo Helper::json($out);