<?php

use MyECOMM\PayPal;
use MyECOMM\Helper;

// Initialize PayPal object and call IPN
$objPayPal = new PayPal();
$succeed = $objPayPal->ipn();

if (!$succeed)
{
    Helper::redirect('/?page=error');
}