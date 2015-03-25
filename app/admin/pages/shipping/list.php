<?php

use MyECOMM\Validation;
use MyECOMM\Country;
use MyECOMM\Plugin;

$objValidation = new Validation();

$objCountry = new Country();
$countries = $objCountry->getAllExceptLocal();

$zones = $objShipping->getZones();

$international = $objShipping->getTypes();
$local = $objShipping->getTypes(1);

$urlSort = $this->objUrl->getCurrent(['action', 'id'], false, ['action', 'sort']);

require_once('_header.php'); ?>

<div class="listing shipping-type-list">
    <div class="breadcrumbs">
        <ul>
            <li class="dashboard">
                <a href="/panel/dashboard" title="Go to Dashboard">Dashboard</a>
                <span>&nbsp;</span>
            </li>
            <li>
                <strong>
                    Shipping Types
                </strong>
            </li>
        </ul>
    </div>
    <div class="page-title">
        <h1>Shipping Types</h1>
    </div>
    <div class="shipping-type-add">
        <form method="post" class="ajax" data-action="<?php
            echo $this->objUrl->getCurrent(['action', 'id'], false, ['action', 'add']);
        ?>">
            <table>
                <tr>
                    <td>
                        <label for="name">
                            Type Name: <em>*</em>
                        </label>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="fld"
                            placeholder="Add a new shipping type..."
                        />
                    </td>
                    <td class="local">
                        <input
                            type="checkbox"
                            name="local"
                            id="local"
                            checked="checked"
                            />
                        <label for="local">
                            Local
                        </label>
                    </td>
                    <td>
                        <button class="button" type="submit">
                                <span>
                                        <span>Add</span>
                                </span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="valid_name"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="clearfix"></div>
<form method="post" data-url="<?php echo $this->objUrl->getCurrent(
    ['action', 'id'], false, ['action', 'update', 'id']) . '/';
?>" class="form-shipping-types">
    <fieldset>
        <legend>Local Types</legend>
        <div id="typesLocal">
            <?php echo Plugin::get('admin'.DS.'shipping', [
                'rows' => $local,
                'zones' => $zones,
                'objUrl' => $this->objUrl,
                'urlSort' => $urlSort
            ]); ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>International Types</legend>
        <div id="typesInternational">
            <?php echo Plugin::get('admin'.DS.'shipping', [
                'rows' => $international,
                'countries' => $countries,
                'objUrl' => $this->objUrl,
                'urlSort' => $urlSort
            ]); ?>
        </div>
    </fieldset>
</form>

<?php require_once('_footer.php'); ?>