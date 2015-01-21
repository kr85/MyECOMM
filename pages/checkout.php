<?php

$objForm = new Form();


require_once('_header.php')
?>

<h1>Checkout</h1>

<p>Please check your details and click <strong>Next</strong>.</p>

<form action="" method="POST">
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
        <tr>
            <th><label for="first_name">First name: *</label></th>
            <td>
                <input type="text" name="first_name"
                       id="first_name" class="fld"
                       value="<?php echo $objForm->stickyText('first_name') ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="last_name">Last name: *</label></th>
            <td>
                <input type="text" name="last_name"
                       id="last_name" class="fld"
                       value="<?php echo $objForm->stickyText('last_name') ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="address_1">Address 1: *</label></th>
            <td>
                <input type="text" name="address_1"
                       id="address_1" class="fld"
                       value="<?php echo $objForm->stickyText('address_1') ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="address_2">Address 2: </label></th>
            <td>
                <input type="text" name="address_2"
                       id="address_2" class="fld"
                       value="<?php echo $objForm->stickyText('address_2') ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="city">City: *</label></th>
            <td>
                <input type="text" name="city"
                       id="city" class="fld"
                       value="<?php echo $objForm->stickyText('city') ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="state">State: *</label></th>
            <td>
                <input type="text" name="state"
                       id="state" class="fld"
                       value="<?php echo $objForm->stickyText('state') ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="zip_code">ZIP code: *</label></th>
            <td>
                <input type="text" name="zip_code"
                       id="zip_code" class="fld"
                       value="<?php echo $objForm->stickyText('zip_code') ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="country">Country: *</label></th>
            <td>
                <?php echo $objForm->getCountriesSelect(); ?>
            </td>
        </tr>
        <tr>
            <th><label for="email">Email address: *</label></th>
            <td>
                <input type="text" name="email"
                       id="email" class="fld"
                       value="<?php echo $objForm->stickyText('email') ?>" />
            </td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>
                <label for="btn" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn" class="btn" value="Next" />
                </label>
            </td>
        </tr>
    </table>
</form>

<?php require_once('_footer.php') ?>