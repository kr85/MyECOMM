<?php

use MyECOMM\Login;
use MyECOMM\Session;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Books - Online Store</title>
        <meta name="description" content="Books - Online Store"/>
        <meta name="viewport" content="width=device-width">
        <link href="/assets/main/all.css" rel="stylesheet" type="text/css"/>
        <script src="/assets/js/lib/modernizr.js" type="text/javascript"></script>
    </head>
    <body class="admin">
        <div class="wrapper">
            <header>
                <div class="header-row-1">
                    <div class="header-row-1-container">
                        <nav>
                            <ul>
                                <li class="logo-wrapper">
                                    <span>Content Management System</span>
                                </li>
                            </ul>
                            <div class="logged_as">
                                <span>
                                    <?php if (Login::isLogged(Login::$loginAdmin)): ?>
                                        Logged in as:
                                        <strong>
                                        <?php
                                            echo Login::getFullNameAdmin(
                                                Session::getSession(Login::$loginAdmin)
                                            );
                                        ?>
                                        </strong>
                                        <span class="logout">
                                            <a href="/panel/logout">Log Out</a>
                                        </span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </nav>
                    </div>
                </div>
            </header>
            <section>
                <div class="container">
                    <div class="main pad-bottom">
                        <div class="col-main">