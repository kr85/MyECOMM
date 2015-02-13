<?php

    $id = $this->objUrl->get('id');

    if (!empty($id)) {

        // Restrict access only for logged in users
        Login::restrictAdmin();

        $objUser = new User();
        $user = $objUser->getUser($id);

        if (!empty($user)) {

            $objForm = new Form();
            $objValidation = new Validation($objForm);

            // Edit form
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

                    'shipping_address_1',
                    'shipping_address_2',
                    'shipping_city',
                    'shipping_state',
                    'shipping_zip_code',
                    'shipping_country',

                    'email'
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
                    'email'
                ];

                // Special validation field
                $objValidation->special = [
                    'email' => 'email'
                ];

                // Get the email from post and user by email
                $email = $objForm->getPost('email');
                $duplicate = $objUser->getByEmail($email);

                // Check if the email already exist
                if (!empty($duplicate) && $duplicate['id'] != $user['id']) {
                    $objValidation->addToErrors('email_duplicate');
                }

                // Check if validation was successful
                if ($objValidation->isValid()) {

                    if ($objUser->updateUser(
                        $objValidation->post,
                        $user['id']
                    )
                    ) {
                        Helper::redirect(
                            $this->objUrl->getCurrent(
                                ['action', 'id'], false, ['action', 'edited']
                            )
                        );
                    } else {
                        Helper::redirect(
                            $this->objUrl->getCurrent(
                                ['action', 'id'], false, ['action', 'edited-failed']
                            )
                        );
                    }
                }
            }
            require_once('_header.php');

            ?>

            <h1>Clients :: Edit</h1>

            <form action="" method="POST">
                <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
                    <tr>
                        <th><label for="first_name">First Name: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('first_name') ?>
                            <input type="text" name="first_name" id="first_name"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'first_name',
                                       $user['first_name']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="last_name">Last Name: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('last_name') ?>
                            <input type="text" name="last_name" id="last_name"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'last_name',
                                       $user['last_name']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="email">Email address: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('email') ?>
                            <input type="text" name="email" id="email"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'email',
                                       $user['email']
                                   )
                                   ?>"/>
                        </td>
                    </tr>
                </table>

                <h3>Billing Address</h3>

                <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
                    <tr>
                        <th><label for="address_1">Address 1: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('address_1') ?>
                            <input type="text" name="address_1" id="address_1"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'address_1',
                                       $user['address_1']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="address_2">Address 2: </label></th>
                        <td>
                            <?php echo $objValidation->validate('address_2') ?>
                            <input type="text" name="address_2" id="address_2"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'address_2',
                                       $user['address_2']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="city">City: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('city') ?>
                            <input type="text" name="city" id="city" class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'city',
                                       $user['city']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="state">State: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('state') ?>
                            <input type="text" name="state" id="state"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'state',
                                       $user['state']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="zip_code">ZIP code: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('zip_code') ?>
                            <input type="text" name="zip_code" id="zip_code"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'zip_code',
                                       $user['zip_code']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="country">Country: *</label></th>
                        <td>
                            <?php echo $objValidation->validate('country') ?>
                            <?php echo $objForm->getCountriesSelect(
                                $user['country']
                            );
                            ?>
                        </td>
                    </tr>
                </table>

                <h3>Shipping Address</h3>

                <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
                    <tr>
                        <th><label for="shipping_address_1">Address 1: </label></th>
                        <td>
                            <?php echo $objValidation->validate('shipping_address_1') ?>
                            <input type="text" name="shipping_address_1"
                                   id="shipping_address_1" class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'shipping_address_1',
                                       $user['shipping_address_1']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="shipping_address_2">Address 2: </label></th>
                        <td>
                            <?php echo $objValidation->validate('shipping_address_2') ?>
                            <input type="text" name="shipping_address_2"
                                   id="shipping_address_2" class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'shipping_address_2',
                                       $user['shipping_address_2']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="shipping_city">City: </label></th>
                        <td>
                            <?php echo $objValidation->validate('shipping_city') ?>
                            <input type="text" name="shipping_city"
                                   id="shipping_city" class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'shipping_city',
                                       $user['shipping_city']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="shipping_state">State: </label></th>
                        <td>
                            <?php echo $objValidation->validate('shipping_state') ?>
                            <input type="text" name="shipping_state" id="shipping_state"
                                   class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'shipping_state',
                                       $user['shipping_state']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="shipping_zip_code">ZIP code: </label></th>
                        <td>
                            <?php echo $objValidation->validate('shipping_zip_code') ?>
                            <input type="text" name="shipping_zip_code"
                                   id="shipping_zip_code" class="fld"
                                   value="<?php echo $objForm->stickyText(
                                       'shipping_zip_code',
                                       $user['shipping_zip_code']
                                   ) ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="shipping_country">Country: </label></th>
                        <td>
                            <?php echo $objValidation->validate('shipping_country') ?>
                            <?php echo $objForm->getCountriesSelect(
                                $user['shipping_country'],
                                'shipping_country',
                                true
                            );
                            ?>
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" class="tbl_insert">
                    <tr>
                        <td>
                            <label for="btn" class="sbm sbm_blue fl_l"> <input
                                    type="submit" id="btn" class="btn"
                                    value="Update"/> </label>
                        </td>
                    </tr>
                </table>
            </form>

            <?php
            require_once('_footer.php');
        }
    }
?>
