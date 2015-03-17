<?php

use MyECOMM\Helper;

$filenames = [];
$path = null;
$type = null;

if ($_POST['type']) {
    $type = $_POST['type'];
    if ($type[0] == 'images') {
        $path[0] = IMAGES_PATH;
    }

    if ($type[1] == 'catalog') {
        $path[1] = CATALOG_PATH;
    }
}

$handle = opendir($path[0]);

while ($file = readdir($handle)) {
    if ($file !== '.' && $file !== '..') {
        array_push($filenames, DS.ASSETS_DIR.DS.IMAGES_DIR.DS.$file);
    }
}

$handle = opendir($path[1]);

while ($file = readdir($handle)) {
    if ($file !== '.' && $file !== '..') {
        array_push($filenames, DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$file);
    }
}

echo Helper::json(['error' => false, 'filenames' => $filenames]);

