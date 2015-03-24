<?php

use MyECOMM\Plugin;

$shipping = $objShipping->getShippingByTypeCountry($id, $zid);

require_once('_header.php');

?>

<div class="listing shipping-rates">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li class="dashboard">
                <a href="/panel/shipping" title="Go to Shipping Types">Shipping Types</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Rates for <?php echo $country['name']; ?> :: <?php echo $type['name']; ?>
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Rates for <?php echo $country['name']; ?> :: <?php echo $type['name']; ?></h1>
    </div>
    <div class="shipping-rate-add">
        <form method="post" class="ajax" data-action="<?php
        echo $this->objUrl->getCurrent('call', false, ['call', 'add']);
        ?>">
            <table>
                <tr>
                    <td>
                        <label for="weight" class="valid_weight">
                            Weight up to: <em>*</em>
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="weight"
                            id="weight"
                            class="fld_small"
                            />
                    </td>
                    <td>
                        <label for="cost" class="valid_cost">
                            Cost: <em>*</em>
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="cost"
                            id="cost"
                            class="fld_small"
                            />
                    </td>
                    <td>
                        <button class="button" type="submit">
                                <span>
                                        <span>Add</span>
                                </span>
                        </button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="clearfix"></div>
<div id="shippingList">
    <?php echo Plugin::get('admin'.DS.'shipping-cost', [
        'rows' => $shipping,
        'objUrl' => $this->objUrl,
        'objCurrency' => $this->objCurrency
    ]); ?>
</div>
<div class="buttons-set">
    <a
        href="javascript:history.go(-1)"
        class="left back-btn">
        <small>« </small>Back
    </a>
</div>
<?php require_once('_footer.php') ?>