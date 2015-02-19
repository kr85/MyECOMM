<?php

    $objValidation = new Validation();

    $objCountry = new Country();
    $countries = $objCountry->getAllExceptLocal();


    $zones = $objShipping->getZones();

    $international = $ObjShipping->getTypes();
    $local = $objShipping->getTypes(1);

    $urlSort = $this->objUrl->getCurrent(['action', 'id'], false, ['action', 'sort']);

    require_once('_header.php');
?>

<h1>Shipping Types</h1>

<?php require_once('_footer.php'); ?>