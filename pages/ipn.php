<?php

// Initialize PayPal object and call IPN
$objPayPal = new PayPal();
$objPayPal->ipn();