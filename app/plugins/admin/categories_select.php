<?php

use MyECOMM\Form;

$objForm = new Form();

$sectionId = 0;
if ($data['sectionId']) {
    $sectionId = $data['sectionId'];
} elseif ($data['stickySection']) {
    $sectionId = $data['stickySection'];
}

echo $objForm->getSectionCategoriesSelect($sectionId, $data['stickyCategory']);

