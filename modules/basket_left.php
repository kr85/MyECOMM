<?php

    // Instantiate basket class
    $objBasket = is_object($objBasket) ? $objBasket : new Basket();
    // Instantiate url class
    $objUrl = new Url();

?>

<h2>Your Basket</h2>
<dl id="basket_left">
    <dt>
        No. of items:
    </dt>
    <dd class="bl_ti">
        <span>
            <?php
                echo $objBasket->numberOfItems;
            ?>
        </span>
    </dd>
    <dt>
        Subtotal:
    </dt>
    <dd class="bl_st">
        <span>
            <?php
                echo Catalog::$currency;
                echo number_format($objBasket->subTotal, 2);
            ?>
        </span>
    </dd>
</dl>
<div class="dev br_td">&#160;</div><p>
    <a href="<?php echo $objUrl->href('basket'); ?>">View Basket</a> | <a
        href="<?php echo $objUrl->href('checkout'); ?>">Checkout</a>
</p>
<div class="dev br_td">&#160;</div>