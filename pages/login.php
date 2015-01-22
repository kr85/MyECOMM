<?php

$objForm = new Form();

require_once('_header.php');

?>

<h1>Log In</h1>

<form action="" method="POST">
    <table cellpadding="0", cellspacing="0" border="0" class="tbl_insert">
        <tr>
            <th>
                <label for="login_email">Email:</label>
            </th>
            <td>
                <input type="text" name="login_email"
                       id="login_email" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="login_password">Password:</label>
            </th>
            <td>
                <input type="text" name="login_password"
                       id="login_password" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>&#160;</th>
            <td>
                <label for="btn_login" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn_login" class="btn" value="Log In"/>
                </label>
            </td>
        </tr>
    </table>
</form>

<div class="dev br_td">&#160;</div>
<h3>Not registered yet?</h3>

<form action="" method="POST">
    <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
        <tr>
            <th>
                <label for="first_name">First name: *</label>
            </th>
            <td>
                <input type="text" name="first_name"
                       id="first_name" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="last_name">Last name: *</label>
            </th>
            <td>
                <input type="text" name="last_name"
                       id="last_name" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="address_1">Address 1: *</label>
            </th>
            <td>
                <input type="text" name="address_1"
                       id="address_1" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="address_2">Address 2: </label>
            </th>
            <td>
                <input type="text" name="address_2"
                       id="address_2" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="city">City: *</label>
            </th>
            <td>
                <input type="text" name="city"
                       id="city" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="state">State: *</label>
            </th>
            <td>
                <input type="text" name="state"
                       id="state" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="zip_code">ZIP code: *</label>
            </th>
            <td>
                <input type="text" name="zip_code"
                       id="zip_code" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="country">Country: *</label>
            </th>
            <td>
                <?php echo $objForm->getCountriesSelect(); ?>
            </td>
        </tr>
        <tr>
            <th>
                <label for="email">Email address: *</label>
            </th>
            <td>
                <input type="text" name="email"
                       id="email" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="password">Password: *</label>
            </th>
            <td>
                <input type="password" name="password"
                       id="password" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>
                <label for="confirm_password">Password confirmation: *</label>
            </th>
            <td>
                <input type="password" name="confirm_password"
                       id="confirm_password" class="fld" value=""/>
            </td>
        </tr>
        <tr>
            <th>&#160;</th>
            <td>
                <label for="btn" class="sbm sbm_blue fl_l">
                    <input type="submit" id="btn" class="btn" value="Sign Up"/>
                </label>
            </td>
        </tr>
    </table>
</form>

<?php require_once('_footer.php'); ?>