<?php

    if ($type['default'] == 1) {
        throw new Exception('This is already a default shipping type.');
    }

    if ($objShipping->setTypeDefault($type['id'], $type['local'])) {
        echo Helper::json(['error' => false]);
    } else {
        throw new Exception('Record could not be updated.');
    }