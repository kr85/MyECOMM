<?php

use MyECOMM\Login;
use MyECOMM\User;
use MyECOMM\Session;
use MyECOMM\Basket;
use MyECOMM\Shipping;
use MyECOMM\Helper;

$shipping = $this->objUrl->get('shipping');

if (!empty($shipping)) {

    Login::restrictFront();

    $objUser = new User();
    $user = $objUser->getUser(Session::getSession(Login::$loginFront));

    if (!empty($user)) {

        $objBasket = new Basket($user);
        $objShipping = new Shipping($objBasket);
        $shippingSelected = $objShipping->getShipping($user, $shipping);

        if (!empty($shippingSelected)) {

            if ($objBasket->addShipping($shippingSelected)) {

                $out = [];
                $out['basketSubtotal'] = '<i>'.$this->objCurrency->display(
                    number_format($objBasket->finalSubtotal, 2)
                ).'</i>';
                $out['basketShippingCost'] = '<i>'.$this->objCurrency->display(
                    number_format($shippingSelected['cost'], 2)
                ).'</i>';
                $out['basketTax'] = '<i>'.$this->objCurrency->display(
                    number_format($objBasket->finalTax, 2)
                ).'</i>';
                $out['basketTotal'] = '<strong>'.$this->objCurrency->display(
                    number_format($objBasket->finalTotal, 2)
                ).'</strong>';

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
