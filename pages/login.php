<?php

    // Check if user is logged in
    if (Login::isLogged(Login::$loginFront)) {
        Helper::redirect(Login::$dashboardFront);
    }

    $objForm = new Form();
    $objValidation = new Validation($objForm);
    $objUser = new User($this->objUrl);

    // Log In form
    if ($objForm->isPost('login_email')) {
        if ($objUser->isUser(
            $objForm->getPost('login_email'),
            $objForm->getPost('login_password')
        )
        ) {
            Login::loginFront(
                $objUser->id,
                $this->objUrl->href($this->objUrl->get(Login::$referrer))
            );
        } else {
            $objValidation->addToErrors('login');
        }
    }

    // Sign Up form
    if ($objForm->isPost('first_name')) {

        // Expected fields
        $objValidation->expected = [
            'first_name',
            'last_name',
            'address_1',
            'address_2',
            'city',
            'state',
            'zip_code',
            'country',
            'email',
            'password',
            'confirm_password'
        ];

        // Required fields
        $objValidation->required = [
            'first_name',
            'last_name',
            'address_1',
            'city',
            'state',
            'zip_code',
            'country',
            'email',
            'password',
            'confirm_password'
        ];

        // Special validation field
        $objValidation->special = [
            'email' => 'email'
        ];

        // Fields that should not be processed after validation
        $objValidation->postRemove = [
            'confirm_password'
        ];

        // Format (hash) password after post
        $objValidation->postFormat = [
            'password' => 'password'
        ];

        // Check if passwords match
        $password_1 = $objForm->getPost('password');
        $password_2 = $objForm->getPost('confirm_password');

        if (!empty($password_1) && !empty($password_2) && $password_1 != $password_2) {
            $objValidation->addToErrors('password_mismatch');
        }

        // Check if email already exist
        $email = $objForm->getPost('email');
        $user = $objUser->getByEmail($email);

        if (!empty($user)) {
            if ($user['active'] != 1) {
                $emailInactive = '<a href="" id="email_inactive"';
                $emailInactive .= ' data-id="';
                $emailInactive .= $user['id'];
                $emailInactive .= '">Email address is already taken.';
                $emailInactive .= ' Resend activation email.</a>';
                $objValidation->message['email_inactive'] = $emailInactive;
                $objValidation->addToErrors('email_inactive');
            } else {
                $objValidation->addToErrors('email_duplicate');
            }
        }

        // Check if validation is valid
        if ($objValidation->isValid()) {

            // Add hash for activation account
            $objValidation->post['hash'] = mt_rand() . date('YmdHis') . mt_rand(
                );

            // Add registration date
            $objValidation->post['date'] = Helper::setDate();

            if ($objUser->addUser(
                $objValidation->post,
                $objForm->getPost('password')
            )
            ) {
                Helper::redirect($this->objUrl->href('registered'));
            } else {
                Helper::redirect($this->objUrl->href('registered-failed'));
            }
        }
    }

    require_once('_header.php');
?>

    <h1>Log In</h1>

    <form action="" method="POST">
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
            <tr>
                <th>
                    <label for="login_email">Email address:</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('login'); ?>
                    <input type="email" name="login_email" id="login_email"
                           class="fld" value="<?php echo $objForm->stickyText(
                        'login_email'
                    ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="login_password">Password:</label>
                </th>
                <td>
                    <input type="password" name="login_password"
                           id="login_password" class="fld" value=""/>
                </td>
            </tr>
            <tr>
                <th>&#160;</th>
                <td>
                    <label for="btn_login" class="sbm sbm_blue fl_l"> <input
                            type="submit" id="btn_login" class="btn"
                            value="Log In"/> </label>
                </td>
            </tr>
        </table>
    </form>

    <div class="dev br_td">&#160;</div>
    <h1>Not registered yet?</h1>

    <form action="" method="POST">
        <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
            <tr>
                <th>
                    <label for="first_name">First name: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('first_name'); ?>
                    <input type="text" name="first_name" id="first_name"
                           class="fld" value="<?php echo $objForm->stickyText(
                        'first_name'
                    ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="last_name">Last name: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('last_name'); ?>
                    <input type="text" name="last_name" id="last_name"
                           class="fld" value="<?php echo $objForm->stickyText(
                        'last_name'
                    ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="address_1">Address 1: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('address_1'); ?>
                    <input type="text" name="address_1" id="address_1"
                           class="fld" value="<?php echo $objForm->stickyText(
                        'address_1'
                    ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="address_2">Address 2: </label>
                </th>
                <td>
                    <?php echo $objValidation->validate('address_2'); ?>
                    <input type="text" name="address_2" id="address_2"
                           class="fld" value="<?php echo $objForm->stickyText(
                        'address_2'
                    ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="city">City: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('city'); ?>
                    <input type="text" name="city" id="city" class="fld"
                           value="<?php echo $objForm->stickyText('city'); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="state">State: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('state'); ?>
                    <input type="text" name="state" id="state" class="fld"
                           value="<?php echo $objForm->stickyText(
                               'state'
                           ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="zip_code">ZIP code: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('zip_code'); ?>
                    <input type="text" name="zip_code" id="zip_code" class="fld"
                           value="<?php echo $objForm->stickyText(
                               'zip_code'
                           ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="country">Country: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('country'); ?>
                    <?php echo $objForm->getCountriesSelect(); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="email">Email address: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('email'); ?>
                    <?php echo $objValidation->validate('email_duplicate'); ?>
                    <?php echo $objValidation->validate('email_inactive'); ?>
                    <input type="email" name="email" id="email" class="fld"
                           value="<?php echo $objForm->stickyText(
                               'email'
                           ); ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="password">Password: *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('password'); ?>
                    <?php echo $objValidation->validate('password_mismatch'); ?>
                    <input type="password" name="password" id="password"
                           class="fld" value=""/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="confirm_password">Password confirmation:
                        *</label>
                </th>
                <td>
                    <?php echo $objValidation->validate('confirm_password'); ?>
                    <input type="password" name="confirm_password"
                           id="confirm_password" class="fld" value=""/>
                </td>
            </tr>
            <tr>
                <th>&#160;</th>
                <td>
                    <label for="btn" class="sbm sbm_blue fl_l"> <input
                            type="submit" id="btn" class="btn" value="Sign Up"/>
                    </label>
                </td>
            </tr>
        </table>
    </form>

<?php require_once('_footer.php'); ?>