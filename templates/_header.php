<?php

    $objCatalogue = new Catalogue();
    $categories = $objCatalogue->getCategories();

    $objBusiness = new Business();
    $business = $objBusiness->getBusiness();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>E-Commerce Website Project</title>
        <meta name="description" content="E-Commerce Website Project" />
        <meta name="keywords" content="E-Commerce Website Project" />
        <meta http-equiv="imagetoolbar" content="no" />
        <link href="/css/core.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <div id="header">
        <div id="header_in">
            <h5><a href="/"><?php echo $business['name']; ?></a></h5>
        </div>
    </div>
    <div id="outer">
        <div id="wrapper">
            <div id="left">
                <h2>Categories</h2>
                <ul id="navigation">
                    <?php
                        if (!empty($categories))
                        {
                            foreach ($categories as $category)
                            {
                                echo "<li><a href=\"/?page=catalogue&amp;category=".$category['id']."\"";
                                echo Helper::getActive(['category' => $category['id']]);
                                echo ">";
                                echo Helper::encodeHTML($category['name']);
                                echo "</a></li>";
                            }
                        }
                    ?>
                </ul>
            </div>
            <div id="right">