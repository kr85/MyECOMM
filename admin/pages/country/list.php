<?php

    $countries = $objCountry->getAll();

    require_once('_header.php');
?>

<h1>Countries</h1>

<form method="post" class="ajax" data-action="<?php
    echo $this->objUrl->getCurrent(['action', 'id'], false, ['action', 'add']);
?>">
    <table class="tbl_insert">
        <thead>
            <tr>
                <th><label for="name" class="valid_name">Country Name: *</label></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" name="name" id="name" class="fld"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="btn_add" class="sbm sbm_blue fl_l">
                        <input type="submit" class="btn" id="btn_add" value="Add"/>
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<div class="dev br_td">&nbsp;</div>

<form method="post" data-url="<?php
    echo $this->objUrl->getCurrent(
            ['action', 'id'],
            false,
            ['action', 'update', 'id']
        ) . '/';
?>">
    <div id="countryList">
        <?php echo Plugin::get('admin' . DS . 'country', [
            'rows' => $countries,
            'objUrl' => $this->objUrl
        ]); ?>
    </div>
</form>

<?php require_once('_footer.php') ?>