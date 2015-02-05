<?php

    require_once('../includes/config.php');

    // Create tokens
    $token2 = Session::getSession('token2');
    $objForm = new Form();
    $token1 = $objForm->getPost('token');

    if ($token2 == Login::stringToHash($token1)) {

        // Create a new order
        $objOrder = new Order();

        if ($objOrder->createOrder()) {

            // Get order details
            $order = $objOrder->getOrder();
            $items = $objOrder->getOrderItems();

            if (!empty($order) && !empty($items)) {

                $objBasket = new Basket();
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

                $objPayPal->taxCart = $objBasket->tax;

                // Populate user's details
                $objUser = new User();
                $user = $objUser->getUser($order['client']);

                if (!empty($user)) {

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
                        'last_name'  => $user['last_name']];

                    // Redirect user to PayPal
                    echo $objPayPal->run($order['id']);
                }
            }
        }
    }