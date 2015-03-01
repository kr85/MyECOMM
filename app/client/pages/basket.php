<?php

use MyECOMM\Plugin;

require_once('_header.php'); ?>

<h1>Basket</h1>

<div id="main_basket">
    <?php echo Plugin::get('front'.DS.'basket_view', [
        'objUrl' => $this->objUrl,
        'objCurrency' => $this->objCurrency
    ]); ?>
</div>

<?php require_once('_footer.php'); ?>