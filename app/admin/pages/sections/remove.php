<?php

use MyECOMM\Catalog;
use MyECOMM\Helper;
use MyECOMM\Paging;

$id = $this->objUrl->get('id');

if (!empty($id)) {

    $objCatalog = new Catalog();
    $section = $objCatalog->getSection($id);

    if (!empty($section)) {

        $yes = $this->objUrl->getCurrent().'/remove/1';
        $no = 'javascript:history.go(-1)';

        $remove = $this->objUrl->get('remove');

        if (!empty($remove) && $section['categories_count'] == 0) {
            $objCatalog->removeSection($id);

            Helper::redirect(
                $this->objUrl->getCurrent([
                    'action',
                    'id',
                    'remove',
                    'search',
                    Paging::$key
                ]));
        }

        require_once('_header.php'); ?>

        <h1>Categories :: Remove</h1>

        <p>
            Are you sure you want to remove this section?<br/>
            <a href="<?php echo $yes; ?>">Yes</a> |
            <a href="<?php echo $no; ?>">No</a>
        </p>

        <?php
        require_once('_footer.php');
    }
}
?>