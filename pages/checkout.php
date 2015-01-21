<?php require_once('_header.php') ?>

<h1>Checkout</h1>

<p>Please check your details and click <strong>Next</strong>.</p>

<form action="" method="POST">
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
        <tr>
            <th><label for="first_name">First name: *</label></th>
            <td>
                <input type="text" name="first_name"
                       id="first_name" class="fld" value="" />
            </td>
        </tr>
        <tr>
            <th><label for="last_name">Last name: *</label></th>
            <td>
                <input type="text" name="last_name"
                       id="last_name" class="fld" value="" />
            </td>
        </tr>
        <tr>
            <th><label for="address_1">Address 1: *</label></th>
            <td>
                <input type="text" name="address_1"
                       id="address_1" class="fld" value="" />
            </td>
        </tr>
        <tr>
            <th><label for="address_2">Address 2: </label></th>
            <td>
                <input type="text" name="address_2"
                       id="address_2" class="fld" value="" />
            </td>
        </tr>
        <tr>
            <th><label for="city">City: *</label></th>
            <td>
                <input type="text" name="city"
                       id="city" class="fld" value="" />
            </td>
        </tr>
        <tr>
            <th><label for="county">City: *</label></th>
            <td>
                <input type="text" name="town"
                       id="town" class="fld" value="" />
            </td>
        </tr>
    </table>
</form>

<?php require_once('_footer.php') ?>