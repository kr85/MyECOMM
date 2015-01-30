<?php

    require_once('../includes/autoload.php');

    // Instantiate the url class and get the id from the url
    $objUrl = new Url();
    $id = $objUrl->getRaw('id');

    // Check if the id is empty
    if (!empty($id)) {
        // Instantiate the user and find the user by id
        $objUser = new User($objUrl);
        $user = $objUser->getUser($id);
        // Check if the user is empty
        if (!empty($user)) {
            // Instantiate and process the email
            $objEmail = new Email();
            if ($objEmail->process(1, [
                'email'      => $user['email'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'hash'       => $user['hash']
            ])) {
                echo json_encode(['error' => false]);
            } else {
                echo json_encode(['error' => true]);
            }
        } else {
            echo json_encode(['error' => true]);
        }
    } else {
        echo json_encode(['error' => true]);
    }