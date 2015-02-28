<?php

use \Exception;
use MyECOMM\Session;
use MyECOMM\Form;
use MyECOMM\Login;
use MyECOMM\User;
use MyECOMM\Order;
use MyECOMM\Basket;
use MyECOMM\Catalog;
use MyECOMM\PayPal;
use MyECOMM\Country;
use MyECOMM\Helper;

// Create tokens
$token2 = Session::getSession('token2');
$objForm = new Form();
$token1 = $objForm->getPost('token');

if ($token2 == Login::stringToHash($token1)) {

    $objUser = new User();
    $user = $objUser->getUser(Session::getSession(Login::$loginFront));

    // Create a new order
    $objOrder = new Order();

    if (!empty($user) && $objOrder->createOrder($user)) {

        // Get order details
        $order = $objOrder->getOrder();
        $items = $objOrder->getOrderItems();

        if (!empty($order) && !empty($items)) {

            $objBasket = new Basket($user);
            $objCatalog = new Catalog();
            $objPayPal = new PayPal();

            foreach ($items as $item) {

                $product = $objCatalog->getProduct($item['product']);
                $objPayPal->addProduct(
                    $item['product'],
                    $product['name'],
                    $item['price'],
                    $item['qty']
                );
            }

            $objPayPal->taxCart = $objBasket->finalTax;
            $objPayPal->shipping = $objBasket->finalShippingCost;

            // Get user's country
            $objCountry = new Country();
            $country = $objCountry->getCountry($user['country']);

            // Pre-populate PayPal checkout
            $objPayPal->populateCheckout = [
                'address1'   => $user['address_1'],
                'address2'   => $user['address_2'],
                'city'       => $user['city'],
                'state'      => $user['state'],
                'zip'        => $user['zip_code'],
                'country'    => $country['code'],
                'email'      => $user['email'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name']
            ];

            // Redirect user to PayPal
            $form = $objPayPal->run($order['token']);
            echo Helper::json(['error' => false, 'form' => $form]);

        } else {
            throw new Exception('There was a problem retrieving your order.');
        }
    } else {
        throw new Exception('Order could not be created.');
    }
} else {
    throw new Exception('Invalid request.');
}