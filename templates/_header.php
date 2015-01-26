<?php
    // Instantiate catalog class
    $objCatalog = new Catalog();
    $categories = $objCatalog->getCategories();

    // Instantiate business class
    $objBusiness = new Business();
    $business = $objBusiness->getBusiness();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8"/>
    <title>E-Commerce Website Project</title>
    <meta name="description" content="E-Commerce Website Project"/>
    <meta name="keywords" content="E-Commerce Website Project"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/core.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div id="header">
        <div id="header_in">
            <h5><a href="/"><?php echo $business['name']; ?></a></h5>
            <?php
                if (Login::isLogged(Login::$loginFront)) {
                    ?>
                    <div id="logged_as">
                        Logged in as:
                        <strong>
                            <?php
                                echo Login::getFullNameFront(
                                    Session::getSession(Login::$loginFront)
                                );
                            ?>
                        </strong> |
                        <a href="/?page=orders">My Orders</a> |
                        <a href="/?page=logout">Log Out</a>
                    </div>
                <?php
                }
                else {
                    ?>
                    <div id="logged_as">
                        <a href="/?page=login">
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
                <?php require_once('basket_left.php'); ?>
                <?php if (!empty($categories)) { ?>
                    <h2>Categories</h2>
                    <ul id="navigation">
                        <?php
                            foreach ($categories as $c) {
                                echo "<li>";
                                echo "<a href=\"/?page=catalog&amp;category=" . $c['id'] . "\"";
                                echo Helper::getActive(['category' => $c['id']]);
                                echo ">";
                                echo Helper::encodeHTML($c['name']);
                                echo "</a>";
                                echo "</li>";
                            }
                        ?>
                    </ul>
                <?php } ?>
            </div>
            <div id="right">