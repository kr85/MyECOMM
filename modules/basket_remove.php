<?php

    require_once('../includes/autoload.php');

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        Session::removeItem($id);
    }