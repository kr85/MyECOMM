<?php

// Initialize PayPal object and call IPN
$objPayPal = new PayPal();
$succeed = $objPayPal->ipn();

if (!$succeed)
{
    Helper::addToErrorsLog('IPN_did_not_succeed');
    Helper::redirect('/?page=error');
}