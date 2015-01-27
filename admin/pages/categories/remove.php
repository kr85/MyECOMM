<?php

    $id = Url::getParam('id');

    if (!empty($id)) {

        $objCatalog = new Catalog();
        $product = $objCatalog->getProduct($id);

        if (!empty($product)) {

            $yes = '/admin' . Url::getCurrentUrl() . '&amp;remove=1';
            $no = 'javascript:history.go(-1)';

            $remove = Url::getParam('remove');

            if (!empty($remove)) {
                $objCatalog->removeProduct($id);

                Helper::redirect('/admin' . Url::getCurrentUrl([
                        'action',
                        'id',
                        'remove',
                        'search',
                        Paging::$key
                    ])
                );
            }

            require_once('templates/_header.php'); ?>

        <h1>Products :: Remove</h1>

        <p>
            Are you sure you want to remove this product?<br/>
            <a href="<?php echo $yes; ?>">Yes</a> | <a href="<?php echo $no; ?>">No</a>
        </p>

<?php
            require_once('templates/_footer.php');
        }
    }
?>