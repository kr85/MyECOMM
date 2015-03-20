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
                            Shipping & Returns
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="description-wrapper">
                <div class="page-title">
                    <h2>Shipping & Returns</h2>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Praesent convallis elementum mollis. Aliquam sed ligula
                    id eros placerat vulputate nec eu orci. Proin varius
                    turpis ligula, non condimentum velit pharetra eget. Ut
                    convallis dui leo, non fermentum lorem porta at. Etiam
                    ornare nisi id ante aliquet auctor. Proin maximus pretium
                    enim, et faucibus turpis sollicitudin vel. Suspendisse
                    in suscipit urna. Phasellus feugiat quis dui quis elementum.
                    Sed leo quam, consequat quis justo ut, hendrerit volutpat
                    justo. Nullam cursus nibh consectetur erat malesuada
                    egestas. Curabitur id mi orci. Morbi laoreet purus id
                    risus porttitor fermentum. Integer fringilla lectus at
                    eros finibus, quis dictum leo tincidunt.
                </p>
                <p>
                    Aenean tristique non justo dictum bibendum. Vivamus a
                    mi ac lectus varius viverra. Class aptent taciti sociosqu
                    ad litora torquent per conubia nostra, per inceptos
                    himenaeos. Nunc porttitor ligula sit amet nunc sodales
                    luctus. Maecenas rhoncus lectus velit, ac condimentum
                    libero ultrices vitae. Ut a libero vehicula, gravida dui
                    at, iaculis tortor. Fusce sed aliquet diam. Donec
                    tincidunt efficitur orci, nec placerat quam tristique eu.
                </p>
                <p>
                    Aliquam condimentum enim in euismod malesuada. Suspendisse
                    potenti. Morbi id fringilla enim, euismod egestas neque.
                    Fusce eu volutpat augue. Vestibulum tristique ex sed
                    ipsum iaculis, vitae porta sem luctus. Donec efficitur
                    tincidunt dui, vitae ornare turpis ultricies ac. Nullam
                    hendrerit tellus elit, vitae cursus erat interdum vel.
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