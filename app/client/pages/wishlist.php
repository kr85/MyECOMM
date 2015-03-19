<?php

use MyECOMM\Plugin;

require_once('_header.php'); ?>

<div class="main pad-bottom">
    <div id="main_wishlist">
        <?php
            echo Plugin::get('front'.DS.'wishlist_view', [
                'objUrl' => $this->objUrl,
                'objCurrency' => $this->objCurrency
            ]);
        ?>
    </div>
</div>

<?php require_once('_footer.php'); ?>