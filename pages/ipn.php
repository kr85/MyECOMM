<?php

// Initialize PayPal object and call IPN
$objPayPal = new PayPal();
$succeed = $objPayPal->ipn();

if (!$succeed)
{
    Helper::addToErrorsLog('IPN did not succeed');
    Helper::redirect('/?page=error');
}