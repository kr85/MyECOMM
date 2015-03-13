<?php

use MyECOMM\Plugin;

require_once('_header.php'); ?>

<div class="main">
    <div id="main_basket" style="text-align: center;">
        <?php echo Plugin::get('front'.DS.'cart_view', [
            'objUrl' => $this->objUrl,
            'objCurrency' => $this->objCurrency
        ]); ?>
    </div>
</div>

<?php require_once('_footer.php'); ?>