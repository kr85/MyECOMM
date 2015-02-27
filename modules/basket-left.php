<?php

use MyECOMM\Plugin;

echo Plugin::get('front'.DS.'basket_left', [
    'objUrl' => $this->objUrl,
    'objCurrency' => $this->objCurrency
]);