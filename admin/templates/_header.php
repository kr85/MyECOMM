<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>E-Commerce Website Project</title>
        <meta name="description" content="E-Commerce Website Project" />
        <meta name="keywords" content="E-Commerce Website Project" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/css/core.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="header">
            <div id="header_in">
                <h5>
                    <a href="<?php echo Login::isLogged(Login::$loginAdmin) ?
                        "/admin/?page=products" :
                        "/admin/" ?>">
                        Content Management System
                    </a>
                </h5>
                <?php
                    if (Login::isLogged(Login::$loginAdmin))
                    {
                ?>
                    <div id="logged_as">
                        Logged in as:
                        <strong>
                            <?php
                                echo Login::getFullNameFront(
                                    Session::getSession(Login::$loginAdmin)
                                );
                            ?>
                        </strong> |
                        <a href="/admin/?page=logout">Log Out</a>
                    </div>
                <?php
                    }
                    else
                    {
                ?>
                    <div id="logged_as">
                        <a href="/admin/">
                            Log In
                        </a>
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
                            <a href="/admin/?page=products"
                                <?php echo Helper::getActive([
                                    'page' => 'products'
                                ]); ?>>
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="/admin/?page=categories"
                                <?php echo Helper::getActive([
                                    'page' => 'categories'
                                ]); ?>>
                                Categories
                            </a>
                        </li>
                        <li>
                            <a href="/admin/?page=orders"
                                <?php echo Helper::getActive([
                                    'page' => 'orders'
                                ]); ?>>
                                Orders
                            </a>
                        </li>
                        <li>
                            <a href="/admin/?page=clients"
                                <?php echo Helper::getActive([
                                    'page' => 'clients'
                                ]); ?>>
                                Clients
                            </a>
                        </li>
                        <li>
                            <a href="/admin/?page=business"
                                <?php echo Helper::getActive([
                                    'page' => 'business'
                                ]); ?>>
                                Business
                            </a>
                        </li>
                    </ul>
                    <?php } else { ?>
                        &nbsp;
                    <?php } ?>
                </div>
                <div id="right">