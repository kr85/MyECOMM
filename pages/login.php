<?php require_once('_header.php'); ?>

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

<?php require_once('_footer.php'); ?>