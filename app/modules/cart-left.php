<?php

use MyECOMM\Plugin;

echo Plugin::get('front'.DS.'cart_left', [
    'objUrl' => $this->objUrl,
    'objCurrency' => $this->objCurrency
]);