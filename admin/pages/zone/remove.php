<?php

    if ($objShipping->removeZone($zone['id'])) {
        echo Helper::json(['error' => false]);
    } else {
        throw new Exception('Record could not be removed.');
    }