<?php

    $id = $this->objUrl->get('id');

    if (!empty($id)) {

        $objCatalog = new Catalog();
        $category = $objCatalog->getCategory($id);

        if (!empty($category)) {

            $yes = $this->objUrl->getCurrent() . '/remove/1';
            $no = 'javascript:history.go(-1)';

            $remove = $this->objUrl->get('remove');

            if (!empty($remove) && $category['products_count'] == 0) {
                $objCatalog->removeCategory($id);

                Helper::redirect($this->objUrl->getCurrent([
                        'action',
                        'id',
                        'remove',
                        'search',
                        Paging::$key
                    ])
                );
            }

            require_once('_header.php'); ?>

        <h1>Categories :: Remove</h1>

        <p>
            Are you sure you want to remove this category?<br/>
            <a href="<?php echo $yes; ?>">Yes</a> |
            <a href="<?php echo $no; ?>">No</a>
        </p>

<?php
            require_once('_footer.php');
        }
    }
?>