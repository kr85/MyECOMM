<?php

    $objForm = new Form();
    $value = $objForm->getPost('value');

    if (!empty($value)) {
        if ($objCountry->update(['name' => $value], $country['id'])) {
            echo Helper::json(['error' => false]);
        } else {
            throw new Exception('Record could not be updated.');
        }
    } else {
        throw new Exception('Invalid entry.');
    }