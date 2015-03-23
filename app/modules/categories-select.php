<?php

use MyECOMM\Plugin;
use MyECOMM\Helper;

$out = [];
$sectionId = 0;

if ($_POST['sectionId']) {
    $sectionId = $_POST['sectionId'];
}

$out['replace_values']['#categories_select_plugin'] = Plugin::get('admin'.DS.'categories_select', [
    'sectionId' => $sectionId
]);

$out['error'] = false;
echo Helper::json($out);