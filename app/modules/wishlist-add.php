<?php

use MyECOMM\Helper;
use MyECOMM\Catalog;
use MyECOMM\User;
use MyECOMM\Session;
use MyECOMM\Login;

$objCatalog = new Catalog();

$objUser = new User();
$user = $objUser->getUser(Session::getSession(Login::$loginFront));

if (!empty($user)) {
    if (isset($_POST['id'])) {
        $productId = $_POST['id'];
        if (!$objCatalog->isProductInWishlist($productId, $user['id'])) {
            $array = [
                'client' => $user['id'],
                'product' => $productId,
            ];
            $result = $objCatalog->addProductToWishlist($array);
            if ($result) {
                echo Helper::json([
                    'error' => false,
                    'message' => 'Product was successfully added to your wishlist.'
                ]);
            } else {
                echo Helper::json(['error' => true]);
            }
        } else {
            echo Helper::json([
                'error' => true,
                'message' => 'Product is already in your wishlist.'
            ]);
        }
    } else {
        throw new Exception('Product id was not posted.');
    }
} else {
    echo Helper::json([
        'error' => true,
        'message' => 'Please log in to be able to add to your wishlish.'
    ]);
}