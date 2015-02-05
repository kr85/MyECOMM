<?php

    require_once('../includes/config.php');

    if (isset($_POST['quantity']) && isset($_POST['id'])) {

        $out = [];
        $id = $_POST['id'];
        $value = $_POST['quantity'];
        $objCatalog = new Catalog();
        $product = $objCatalog->getProduct($id);

        if (!empty($product)) {
            switch ($value) {
                case 0:
                    Session::removeItem($id);
                    break;
                default:
                    Session::setItem($id, $value);
            }
        }
    }
