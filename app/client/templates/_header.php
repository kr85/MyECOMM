<?php

use MyECOMM\Catalog;
use MyECOMM\Business;
use MyECOMM\Plugin;
use MyECOMM\Basket;

    // Instantiate catalog class
    $objCatalog = new Catalog();
    $categories = $objCatalog->getCategories();
    $sections = $objCatalog->getSections();
    $latestProducts = $objCatalog->getLatestProducts();

    // Instantiate business class
    $objBusiness = new Business();
    $business = $objBusiness->getOne(Business::BUSINESS_ID);

    // Instantiate basket class
    $objBasket = (is_object($objBasket)) ? $objBasket : new Basket();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $this->metaTitle; ?></title>
    <meta name="description" content="<?php echo $this->metaDescription; ?>"/>
    <meta name="author" content="Kosta Rashev">
    <link href="/assets/main/all.css" rel="stylesheet" type="text/css"/>
    <script src="/assets/js/lib/modernizr.js" type="text/javascript"></script>
</head>
<body>
    <div class="wrapper">
        <header>
            <?php
                echo Plugin::get('front'.DS.'header', [
                    'objUrl' => $this->objUrl,
                    'objCatalog' => $this->objCatalog,
                    'objNavigation' => $this->objNavigation,
                    'objCurrency' => $this->objCurrency,
                    'sections' => $sections,
                    'categories' => $categories,
                    'latestProducts' => $latestProducts
                ]);
            ?>
        </header>
        <?php if ($this->objUrl->currentPage != 'index'): ?>
        <section>
            <div class="container">
        <?php endif; ?>