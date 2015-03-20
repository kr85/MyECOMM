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
                            International Shipping
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="description-wrapper">
                <div class="page-title">
                    <h2>International Shipping</h2>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut
                    vitae ligula ac leo vulputate tempus eu sit amet sapien.
                    Maecenas luctus ante at est congue cursus. Aenean convallis
                    ligula nec erat scelerisque, tempor lobortis nunc lacinia.
                    Curabitur tincidunt, lorem eget maximus congue, leo nisl
                    congue dolor, eget cursus justo dui eget elit. Integer nec
                    tellus ante. Mauris convallis a neque ac pellentesque. Ut
                    eu egestas purus. Etiam ut ex iaculis sapien ullamcorper
                    porta. Suspendisse molestie congue sem, interdum laoreet
                    elit facilisis at. Praesent nec euismod turpis. Sed fermentum
                    lobortis tempor. Nullam consectetur ligula sem, non hendrerit
                    erat viverra in. Etiam sit amet metus urna. Praesent et
                    auctor enim, quis eleifend augue. Aliquam condimentum lacus
                    rutrum blandit gravida.
                </p>
                <p>
                    Etiam et ante ut dui placerat suscipit a id sapien. Etiam
                    in ante ac tellus suscipit tempus ut quis dolor. Vivamus
                    sed ullamcorper dui. Curabitur tincidunt, nibh in euismod
                    semper, nisi arcu lobortis felis, in euismod risus nisi a
                    elit. Ut elementum magna lectus, nec mollis ante luctus
                    ultricies. Quisque rutrum nulla eget neque condimentum
                    euismod. Maecenas feugiat, ipsum nec bibendum consequat,
                    dolor odio dignissim orci, nec porta lacus leo sollicitudin
                    nunc. Aliquam erat volutpat. Suspendisse non risus justo.
                    Quisque sit amet consequat nulla. Sed non eros at nulla
                    vestibulum viverra. Curabitur ac nisi nulla.
                </p>
                <p>
                    Sed id dui dui. Proin laoreet nisl mattis tellus tempor
                    bibendum. Maecenas placerat tristique porta. Nulla posuere
                    facilisis fermentum. Phasellus et risus eget mauris volutpat
                    tincidunt. Donec tincidunt quam quis turpis tincidunt
                    pulvinar. Phasellus et orci tristique, eleifend risus vel,
                    posuere nibh. Integer et risus pharetra, fringilla turpis
                    in, bibendum eros. Phasellus tempus posuere tempor. Sed vel
                    risus commodo, rutrum elit gravida, aliquam dolor.
                    Vestibulum malesuada purus ac neque tincidunt facilisis.
                    Nam vitae lorem mollis, viverra mauris ut, accumsan orci.
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