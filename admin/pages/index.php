<?php

    // Check if the user is logged in and redirect if true
    if (Login::isLogged(Login::$loginAdmin)) {
        Helper::redirect(Login::$dashboardAdmin);
    }

    $objForm = new Form();
    $objValidation = new Validation($objForm);

    if ($objForm->isPost('login_email')) {
        $objAdmin = new Admin();
        if ($objAdmin->isUser(
            $objForm->getPost('login_email'),
            $objForm->getPost('login_password')
        )
        ) {
            Login::loginAdmin(
                $objAdmin->id,
                $this->objUrl->href(
                    $this->objUrl->get(Login::$referrer)
                )
            );
        } else {
            $objValidation->addToErrors('login');
        }
    }
    require_once('_header.php'); ?>

    <h1>Log In</h1>

    <form action="" method="POST">
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
            <tr>
                <th><label for="login_email">Email Address:</label></th>
                <td>
                    <?php echo $objValidation->validate('login'); ?>
                    <input type="text" name="login_email" id="login_email"
                           class="fld" value=""/>
                </td>
            </tr>
            <tr>
                <th><label for="login_password">Password:</label></th>
                <td>
                    <input type="password" name="login_password"
                           id="login_password" class="fld" value=""/>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                    <label for="btn_login" class="sbm sbm_blue fl_l"> <input
                            type="submit" id="btn_login" class="btn"
                            value="Log In"/> </label>
                </td>
            </tr>
        </table>
    </form>

<?php require_once('_footer.php'); ?>