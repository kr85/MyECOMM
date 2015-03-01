<?php

use MyECOMM\User;
use MyECOMM\Email;
use MyECOMM\Helper;

$id = 0;
if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = $this->objUrl->get('id');
}

// Check if the id is empty
if (!empty($id)) {
    // Instantiate the user and find the user by id
    $objUser = new User($this->objUrl);
    $user = $objUser->getUser($id);
    // Check if the user is empty
    if (!empty($user)) {
        // Instantiate and process the email
        $objEmail = new Email($this->objUrl);
        if ($objEmail->process(1, [
            'email'      => $user['email'],
            'first_name' => $user['first_name'],
            'last_name'  => $user['last_name'],
            'hash'       => $user['hash']
        ])) {
            echo Helper::json(['error' => false]);
        } else {
            echo Helper::json(['error' => true]);
        }
    } else {
        echo Helper::json(['error' => true]);
    }
} else {
    echo Helper::json(['error' => true]);
}