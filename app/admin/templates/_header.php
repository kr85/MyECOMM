<?php

use MyECOMM\Login;
use MyECOMM\Session;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>E-Commerce Website Project</title>
        <meta name="description" content="E-Commerce Website Project"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/assets/main/all.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="header">
            <div id="header_in">
                <h5>
                    <a href="<?php echo Login::isLogged(Login::$loginAdmin) ?
                        "/panel/products" :
                        "/panel/" ?>"> Content Management System </a>
                </h5>
                <?php
                    if (Login::isLogged(Login::$loginAdmin)) {
                        ?>
                        <div id="logged_as">
                            Logged in as: <strong>
                                <?php
                                    echo Login::getFullNameAdmin(
                                        Session::getSession(Login::$loginAdmin)
                                    );
                                ?>
                            </strong> | <a href="/panel/logout">Log Out</a>
                        </div>
                    <?php
                    } else {
                        ?>
                        <div id="logged_as">
                            <a href="/panel/"> Log In </a>
                        </div>;
                    <?php
                    }
                ?>
            </div>
        </div>
        <div id="outer">
            <div id="wrapper">
                <div id="left">
                    <?php if (Login::isLogged(Login::$loginAdmin)) { ?>
                        <h2>Navigation</h2>
                        <div class="dev br_td">&nbsp;</div>
                        <ul id="navigation">
                            <li>
                                <a href="/panel/products"
                                    <?php echo $this->objNavigation->active(
                                        'products'
                                    ); ?>> Products </a>
                            </li>
                            <li>
                                <a href="/panel/categories"
                                    <?php echo $this->objNavigation->active(
                                        'categories'
                                    ); ?>> Categories </a>
                            </li>
                            <li>
                                <a href="/panel/orders"
                                    <?php echo $this->objNavigation->active(
                                        'orders'
                                    ); ?>> Orders </a>
                            </li>
                            <li>
                                <a href="/panel/clients"
                                    <?php echo $this->objNavigation->active(
                                        'clients'
                                    ); ?>> Clients </a>
                            </li>
                            <li>
                                <a href="/panel/business"
                                    <?php echo $this->objNavigation->active(
                                        'business'
                                    ); ?>> Business </a>
                            </li>
                            <li>
                                <a href="/panel/shipping"
                                    <?php echo $this->objNavigation->active(
                                        'shipping'
                                    ); ?>> Shipping </a>
                            </li>
                            <li>
                                <a href="/panel/zone"
                                    <?php echo $this->objNavigation->active(
                                        'zone'
                                    ); ?>> Zones </a>
                            </li>
                            <li>
                                <a href="/panel/country"
                                    <?php echo $this->objNavigation->active(
                                        'country'
                                    ); ?>> Countries </a>
                            </li>
                        </ul>
                    <?php } else { ?>
                        &nbsp;
                    <?php } ?>
                </div>
                <div id="right">