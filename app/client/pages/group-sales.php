<?php

use MyECOMM\Plugin;
use MyECOMM\Catalog;

$objCatalog = new Catalog();

require_once('_header.php'); ?>

    <div class="main pad-bottom">
        <div class="col-main">
            <div class="breadcrumbs">
                <ul>
                    <li class="home">
                        <a href="/" title="Go to Home Page">Home</a>
                        <span>&nbsp;</span>
                    </li>
                    <li>
                        <strong>
                            Group Sales
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="description-wrapper">
                <div class="page-title">
                    <h2>Group Sales</h2>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Donec suscipit nulla non interdum vestibulum. Nunc et
                    faucibus magna. Aenean in velit cursus ipsum mattis viverra.
                    Fusce ullamcorper ultrices velit, in imperdiet velit.
                    Curabitur felis massa, posuere ut tortor at, accumsan
                    pulvinar ligula. Donec a massa justo. Morbi varius mauris
                    sapien, id eleifend leo convallis eu. Praesent in diam sit
                    amet ligula aliquet venenatis id vel tortor. Fusce sed nulla
                    at eros varius suscipit eu id tellus. Vestibulum eu velit
                    luctus, ornare tortor et, porta tellus.
                </p>
                <p>
                    Etiam eu molestie neque. Integer efficitur eu libero non
                    gravida. Sed id metus in ipsum facilisis interdum eget id
                    tellus. Quisque non lorem eu dui vulputate auctor quis sit
                    amet mauris. Duis iaculis ante at consequat euismod. Etiam
                    ac vestibulum odio. Quisque eget odio tincidunt, semper
                    massa sit amet, sollicitudin lectus. Pellentesque egestas
                    quam quis libero aliquam, non bibendum ipsum rutrum.
                </p>
                <p>
                    Phasellus eget dolor ligula. Quisque tellus turpis, pharetra
                    at luctus non, maximus nec dolor. Fusce convallis varius
                    purus, eu pharetra ligula. Sed in consectetur velit, at
                    blandit libero. Morbi velit leo, tincidunt ac lorem non,
                    tincidunt euismod tortor. Pellentesque pretium, nibh a
                    accumsan aliquet, orci lorem gravida nulla, quis luctus
                    tortor nunc sit amet enim. Vivamus accumsan posuere volutpat.
                    Integer sit amet ornare tortor, id posuere mauris. Vestibulum
                    tincidunt eros orci, nec suscipit orci hendrerit nec.
                    Pellentesque purus velit, rutrum id sem quis, aliquam ornare
                    nunc. Proin scelerisque magna eu ultricies sollicitudin.
                    Proin ut nibh in justo condimentum luctus. Sed ac magna
                    lobortis, ornare massa et, interdum diam. Phasellus et leo
                    sit amet nisi congue consectetur. Cras eleifend neque
                    laoreet, viverra eros sed, ultricies sem.
                </p>
            </div>
        </div>
        <div class="col-right sidebar">
            <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
                'objUrl' => $this->objUrl,
                'objCurrency' => $this->objCurrency,
                'objCatalog' => $objCatalog,
                'listing' => 'category',
                'id' => 0,
                'productId' => 0,
                'dashboard' => false
            ]); ?>
        </div>
    </div>

<?php require_once('_footer.php'); ?>