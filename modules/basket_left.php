<?php

    // Instantiate basket class
    $objBasket = new Basket();
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
    <dt>
        Tax (
        <span>
            <?php
                echo number_format($objBasket->taxRate, 2);
            ?>
        </span>%):
    </dt>
    <dd class="bl_vat">
        <span>
            <?php
                echo Catalog::$currency;
                echo number_format($objBasket->tax, 2);
            ?>
        </span>
    </dd>
    <dt>
        Total:
    </dt>
    <dd class="bl_total">
        <span>
            <?php
                echo Catalog::$currency;
                echo number_format($objBasket->total, 2);
            ?>
        </span>
    </dd>
</dl>
<div class="dev br_td">&#160;</div>
<p>
    <a href="<?php echo $objUrl->href('basket'); ?>">View Basket</a> |
    <a href="<?php echo $objUrl->href('checkout'); ?>">Checkout</a>
</p>
<div class="dev br_td">&#160;</div>