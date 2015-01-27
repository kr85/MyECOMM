<?php

    $id = Url::getParam('id');

    if (!empty($id)) {

        $objOrder = new Order();
        $order = $objOrder->getOrder($id);

        if (!empty($order)) {

            $yes = '/admin' . Url::getCurrentUrl() . '&amp;remove=1';
            $no = 'javascript:history.go(-1)';

            $remove = Url::getParam('remove');

            if (!empty($remove)) {
                $objOrder->removeOrder($id);

                Helper::redirect('/admin' . Url::getCurrentUrl([
                        'action',
                        'id',
                        'remove',
                        'srch',
                        Paging::$key
                    ])
                );
            }

            require_once('templates/_header.php'); ?>

        <h1>Orders :: Remove</h1>

        <p>
            Are you sure you want to remove this order?<br/>
            <a href="<?php echo $yes; ?>">Yes</a> | <a href="<?php echo $no; ?>">No</a>
        </p>

<?php
            require_once('templates/_footer.php');
        }
    }
?>