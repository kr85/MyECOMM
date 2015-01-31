<?php

    $id = $this->objUrl->get('id');

    if (!empty($id)) {

        $objCatalog = new Catalog();
        $product = $objCatalog->getProduct($id);

        if (!empty($product)) {

            $yes = $this->objUrl->getCurrent() . '/remove/1';
            $no = 'javascript:history.go(-1)';

            $remove = $this->objUrl->get('remove');

            if (!empty($remove)) {
                $objCatalog->removeProduct($id);

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

        <h1>Products :: Remove</h1>

        <p>
            Are you sure you want to remove this product?<br/>
            <a href="<?php echo $yes; ?>">Yes</a> |
            <a href="<?php echo $no; ?>">No</a>
        </p>

<?php
            require_once('_footer.php');
        }
    }
?>