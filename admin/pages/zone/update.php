<?php

    $objForm = new Form();
    $value = $objForm->getPost('value');

    if (!empty($value)) {
        if ($objShipping->updateZone(['name' => $value], $zone['id'])) {
            echo Helper::json(['error' => false]);
        } else {
            throw new Exception('Record could not be update.');
        }
    } else {
        throw new Exception('Invalid entry.');
    }