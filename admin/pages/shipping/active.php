<?php

    $active = ($type['active'] == 1) ? 0 : 1;

    if ($objShipping->updateType(['active' => $active], $type['id'])) {

        $replace = '<a href="#" data-url="';
        $replace .= $this->objUrl->getCurrent();
        $replace .= '" class="click_replace">';
        $replace .= ($active == 1) ? 'Yes' : 'No';
        $replace .= '</a>';

        echo Helper::json(['error' => false, 'replace' => $replace]);
    } else {
        throw new Exception('Record could not be updated.');
    }