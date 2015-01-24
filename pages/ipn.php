<?php

// Initialize PayPal object and call IPN
$objPayPal = new PayPal();
$succeed = $objPayPal->ipn();

if (!$succeed)
{
    Helper::redirect('/?page=error');
}