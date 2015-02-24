<?php
    require_once('../includes/config.php');

    try {
        if (!empty($_GET['shipping'])) {

            Login::restrictFront();
            $objUser = new User();
            $user = $objUser->getUser(Session::getSession(Login::$loginFront));

            if (!empty($user)) {

                $objBasket = new Basket($user);
                $objShipping = new Shipping($objBasket);
                $shippingSelected = $objShipping->getShipping($user, $_GET['shipping']);

                if (!empty($shippingSelected)) {

                    if ($objBasket->addShipping($shippingSelected)) {

                        $out = [];
                        $out['basketSubtotal'] = Catalog::$currency .
                            number_format($objBasket->finalSubtotal, 2);
                        $out['basketTax'] = Catalog::$currency .
                            number_format($objBasket->finalTax, 2);
                        $out['basketTotal'] = Catalog::$currency .
                            number_format($objBasket->finalTotal, 2);

                        echo Helper::json(['error' => false, 'totals' => $out]);

                    } else {
                        throw new Exception('Shipping could not be added.');
                    }
                } else {
                    throw new Exception('Shipping could not be found.');
                }
            } else {
                throw new Exception('User could not be found.');
            }
        } else {
            throw new Exception('Invalid request.');
        }
    } catch (Exception $e) {
        echo Helper::json(['error' => true, 'message' => $e->getMessage()]);
    }