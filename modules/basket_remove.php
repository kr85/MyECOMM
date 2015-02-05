<?php

    require_once('../includes/config.php');

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        Session::removeItem($id);
    }