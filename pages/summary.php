<?php

Login::restrictFront();

$token1 = mt_rand();
$token2 = Login::stringToHash($token1);
Session::setSession('token2', $token2);

$objBasket = new Basket();

$out = [];

$session = Session::getSession('basket');

if (!empty($session))
{
    $objCatalog = new Catalog();

    foreach ($session as $key => $value)
    {
        $out[$key] = $objCatalog->getProduct($key);
    }
}

require_once('_header.php');
?>

<h1>Order summary</h1>

<?php
    if (!empty($out))
    {
?>
        <div id="main_basket">
            <form action="" method="POST" id="frm_basket">
                <table cellpadding="0" cellspacing="0" border="0" class="tbl_repeat">
                    <tr>
                        <th>Item</th>
                        <th class="ta_r">Qty</th>
                        <th class="ta_r col_15">Price</th>
                    </tr>

                    <?php
                        foreach ($out as $item)
                        {
                    ?>
                            <tr>
                                <td>
                                    <?php
                                        echo $item['name'];
                                    ?>
                                </td>
                                <td class="ta_r">
                                    <?php
                                        echo $session[$item['id']]['quantity'];
                                    ?>
                                </td>
                                <td class="ta_r">
                                    <?php
                                    echo Catalog::$currency;
                                    echo number_format(
                                        $objBasket->itemTotal(
                                            $item['price'],
                                            $session[$item['id']]['quantity']
                                        ), 2);
                                    ?>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                            <tr>
                                <td class="dev">&#160;</td>
                            </tr>
                    <?php
                        if ($objBasket->taxRate > 0)
                        {
                    ?>
                            <tr>
                                <td colspan="2" class="br_td">
                                    Sub-total:
                                </td>
                                <td class="ta_r br_td">
                                    <?php
                                        echo Catalog::$currency;
                                        echo number_format($objBasket->subTotal, 2);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="br_td">
                                    TAX (<?php echo $objBasket->taxRate; ?>%)
                                </td>
                                <td class="ta_r br_td">
                                    <?php
                                        echo Catalog::$currency;
                                        echo number_format($objBasket->tax, 2);
                                    ?>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>

                    <tr>
                        <td colspan="2" class="br_td">
                            <strong>Total:</strong>
                        </td>
                        <td class="ta_r br_td">
                            <strong>
                                <?php
                                    echo Catalog::$currency;
                                    echo number_format($objBasket->total, 2);
                                ?>
                            </strong>
                        </td>
                    </tr>
                </table>
                <div class="dev br_td">&#160;</div>
                <div class="sbm sbm_blue fl_r paypal" id="<?php echo $token1; ?>">
                    <span class="btn">
                        Proceed to PayPal
                    </span>
                </div>
                <div class="sbm sbm_blue fl_l">
                    <a href="/?page=basket" class="btn">
                        Back to basket
                    </a>
                </div>
            </form>
            <div class="dev">&#160;</div>
        </div>

<?php
    }
    else
    {
?>
        <p>Your basket is currently empty.</p>
<?php
    }
?>

<?php

require_once('_footer.php');

?>
