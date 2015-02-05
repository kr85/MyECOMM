<?php

    $objBusiness = new Business();
    $business = $objBusiness->getBusiness();

    if (!empty($business)) {

        $objForm = new Form();
        $objValidation = new Validation($objForm);

        if ($objForm->isPost('name')) {
            $objValidation->expected = [
                'name',
                'address',
                'telephone',
                'email',
                'website',
                'tax_rate'
            ];

            $objValidation->required = [
                'name',
                'address',
                'telephone',
                'email',
                'tax_rate'
            ];

            $objValidation->special = [
                'email' => 'email'
            ];

            $variables = $objForm->getPostArray($objValidation->expected);

            if ($objValidation->isValid()) {
                if ($objBusiness->updateBusiness($variables)) {
                    Helper::redirect($this->objUrl->getCurrent([
                            'action',
                            'id'
                        ]) . '/action/edited'
                    );
                } else {
                    Helper::redirect($this->objUrl->getCurrent([
                            'action',
                            'id'
                        ]) . '/action/edited-failed'
                    );
                }
            }
        }

        require_once('_header.php');

?>

        <h1>Business :: Edit</h1>

        <form action="" method="POST">
            <table cellpadding="0" cellspacing="0" border="0"
                   class="tbl_insert">
                <tr>
                    <th><label for="name">Name: *</label></th>
                    <td>
                        <?php echo $objValidation->validate('name') ?>
                        <input type="text" name="name"
                               id="name" class="fld"
                               value="<?php echo $objForm->stickyText(
                                   'name',
                                   $business['name']
                               ); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th><label for="address">Address: *</label></th>
                    <td>
                        <?php echo $objValidation->validate('address') ?>
                        <textarea name="address" id="address"
                            class="tar"><?php echo $objForm->stickyText(
                                'address',
                                $business['address']);
                            ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="telephone">Phone: *</label></th>
                    <td>
                        <?php echo $objValidation->validate('telephone') ?>
                        <input type="text" name="telephone"
                               id="telephone" class="fld"
                               value="<?php echo $objForm->stickyText(
                                   'telephone',
                                   $business['telephone']
                               ); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th><label for="email">Email Address: *</label></th>
                    <td>
                        <?php echo $objValidation->validate('email') ?>
                        <input type="email" name="email"
                               id="email" class="fld"
                               value="<?php echo $objForm->stickyText(
                                   'email',
                                   $business['email']
                               ); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th><label for="website">Website: </label></th>
                    <td>
                        <?php echo $objValidation->validate('website') ?>
                        <input type="text" name="website"
                               id="website" class="fld"
                               value="<?php echo $objForm->stickyText(
                                   'website',
                                   $business['website']
                               ); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th><label for="tax_rate">Tax Rate: *</label></th>
                    <td>
                        <?php echo $objValidation->validate('tax_rate') ?>
                        <input type="text" name="tax_rate"
                               id="tax_rate" class="fld"
                               value="<?php echo $objForm->stickyText(
                                   'tax_rate',
                                   $business['tax_rate']
                               ); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <label for="btn" class="sbm sbm_blue fl_l">
                            <input type="submit" id="btn" class="btn"
                                   value="Update"/>
                        </label>
                    </td>
                </tr>
            </table>
        </form>

        <?php
        require_once('_footer.php');
    }
?>
