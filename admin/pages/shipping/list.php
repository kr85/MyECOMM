<?php

    $objValidation = new Validation();

    $objCountry = new Country();
    $countries = $objCountry->getAllExceptLocal();

    $zones = $objShipping->getZones();

    $international = $objShipping->getTypes();
    $local = $objShipping->getTypes(1);

    $urlSort = $this->objUrl->getCurrent(['action', 'id'], false, ['action', 'sort']);

    require_once('_header.php');
?>

<h1>Shipping Types</h1>

<form method="post" class="ajax" data-action="<?php
    echo $this->objUrl->getCurrent(['action', 'id'], false, ['action', 'add']);
?>">
        <table class="tbl_insert">
            <tr>
                <th>
                    <label for="name" class="valid_name">
                        Type Name:
                    </label>
                </th>
            </tr>
            <tr>
                <td>
                    <label for="local" class="fl_r">
                        <input type="checkbox" name="local" id="local"
                               checked="checked"/>Local
                    </label>
                    <input type="text" name="name" id="name" class="fld mr_r4"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="btn_add" class="sbm sbm_blue fl_l">
                        <input type="submit" id="btn_add" class="btn" value="Add"/>
                    </label>
                </td>
            </tr>
        </table>
</form>
<div class="dev br_td"></div>
<form method="post" data-url="<?php echo $this->objUrl->getCurrent(
        ['action', 'id'], false, ['action', 'update', 'id']) . '/';
?>">

    <h3>Local Types</h3>
    <div id="typesLocal">
        <?php echo Plugin::get('admin' . DS . 'shipping', [
            'rows' => $local,
            'zones' => $zones,
            'objUrl' => $this->objUrl,
            'urlSort' => $urlSort
        ]); ?>
    </div>

    <h3>International Types</h3>
    <div id="typesInternational">
        <?php echo Plugin::get('admin' . DS . 'shipping', [
            'rows' => $international,
            'countries' => $countries,
            'objUrl' => $this->objUrl,
            'urlSort' => $urlSort
        ]); ?>
    </div>
</form>

<?php require_once('_footer.php'); ?>