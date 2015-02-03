<?php

    require_once('../includes/config.php');

    // Check if job and id are set
    if (isset($_POST['job']) && isset($_POST['id'])) {

        $out = [];

        // Store job and id
        $job = $_POST['job'];
        $id = $_POST['id'];

        // Instantiate catalog class
        $objCatalog = new Catalog();
        $product = $objCatalog->getProduct($id);

        if (!empty($product)) {
            switch ($job) {
                case 0:
                    Session::removeItem($id);
                    $out['job'] = 1;
                    break;
                case 1:
                    Session::setItem($id);
                    $out['job'] = 0;
                    break;
            }

            echo Helper::json($out);
        }
    }