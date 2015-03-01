<?php

use \Exception;
use MyECOMM\Helper;

if (!empty($_POST)) {
    $errors = [];

    foreach ($_POST as $row) {
        foreach ($row as $order => $id) {
            $order++;
            if (!$objShipping->updateType(['order' => $order], $id)) {
                $errors[] = $id;
            }
        }
    }

    if (empty($errors)) {
        echo Helper::json(['error' => false]);
    } else {
        throw new Exception(count($errors).' records could not be updated.');
    }
} else {
    throw new Exception('Missing parameter.');
}