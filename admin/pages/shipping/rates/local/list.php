<?php

    $shipping = $objShipping->getShippingByTypeZone($id, $zid);

    require_once('_header.php');
?>

<h1>Rates for : <?php echo $zone['name']; ?> : <?php echo $type['name']; ?></h1>

<form method="post" class="ajax" data-action="<?php
    echo $this->objUrl->getCurrent('call', false, ['call', 'add']);
?>">
    <table class="tbl_insert">
        <tr>
            <th><label for="weight" class="valid_weight">Weight up to: *</label></th>
            <th><label for="cost" class="valid_cost">Cost: *</label></th>
        </tr>
        <tr>
            <td>
                <input type="text" name="weight" id="weight" class="fld fld_small"/>
            </td>
            <td>
                <input type="text" name="cost" id="cost" class="fld fld_small"/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label for="btn_add" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn_add" class="btn" value="Add"/>
                </label>
            </td>
        </tr>
    </table>
</form>
<div class="dev br_td">&nbsp;</div>
<div id="shippingList">
    <?php echo Plugin::get('admin' . DS . 'shipping-cost', [
        'rows' => $shipping,
        'objUrl' => $this->objUrl
    ]); ?>
</div>

<?php require_once('_footer.php') ?>