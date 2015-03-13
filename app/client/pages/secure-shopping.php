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
                            Secure Shopping
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="description-wrapper">
                <div class="page-title">
                    <h2>Secure Shopping</h2>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. In
                    dolor odio, tincidunt eget sollicitudin id, iaculis eu mi.
                    Pellentesque a accumsan nulla. Phasellus fermentum est in
                    magna sollicitudin, at iaculis sapien volutpat. Donec id ex
                    nibh. Aenean convallis aliquam erat. Morbi id turpis commodo,
                    laoreet elit at, bibendum urna. Mauris facilisis metus augue,
                    quis dignissim tellus tincidunt et. Aliquam erat volutpat.
                    Sed volutpat suscipit dui, eget tempus tellus hendrerit ut.
                    Duis interdum, odio sit amet eleifend vestibulum, justo
                    sapien euismod ligula, et sagittis quam sem vitae augue.
                    Nam varius tincidunt faucibus. Etiam aliquet dignissim urna,
                    id dictum libero finibus quis. Phasellus maximus leo erat,
                    eu imperdiet neque porta eu. Mauris semper lacus nec tortor
                    vulputate, nec egestas lorem eleifend.
                </p>
                <p>
                    Praesent aliquam sodales lacus, eu volutpat ipsum fermentum
                    at. Curabitur nec mauris ac ligula elementum dignissim eu at
                    sapien. Nam nec varius nisi. Phasellus quis gravida sem.
                    Nulla sagittis augue vel blandit porta. Suspendisse sem quam,
                    iaculis eu faucibus vel, posuere ac odio. Aliquam erat
                    volutpat. Interdum et malesuada fames ac ante ipsum primis
                    in faucibus. Proin ut eros hendrerit, finibus velit vitae,
                    dictum nulla. Aenean imperdiet felis vitae dui euismod, at
                    facilisis elit efficitur. Proin placerat elit eget eros
                    lobortis dictum. Nunc in sem magna. Vestibulum ante ipsum
                    primis in faucibus orci luctus et ultrices posuere cubilia
                    Curae; Maecenas pulvinar libero nunc, in finibus nulla
                    aliquet eget. Vestibulum eu leo elit. Sed eget justo nunc.
                </p>
                <p>
                    Curabitur id consectetur turpis. Quisque efficitur volutpat
                    bibendum. Suspendisse ac lorem euismod, rutrum purus id,
                    efficitur augue. Mauris porttitor urna placerat nisi vestibulum,
                    vel efficitur lacus venenatis. Fusce ut felis imperdiet,
                    posuere lorem eget, tincidunt metus. Proin quis diam sit
                    amet diam varius lobortis et quis arcu. Proin convallis
                    elementum felis, a aliquam leo dictum nec. Fusce ac mattis
                    lectus, at euismod lacus. Nulla sed lacus id lacus posuere
                    faucibus id non ex. Phasellus lorem turpis, lobortis a
                    mauris in, semper egestas mauris. Nunc blandit, lacus at
                    vehicula ullamcorper, nulla lacus accumsan massa, sed
                    convallis risus eros a sem. Fusce auctor metus eget purus
                    ornare efficitur. Nunc vel purus lorem. Nunc viverra mattis
                    mauris. Pellentesque vel urna sem.
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
                'productId' => 0
            ]); ?>
        </div>
    </div>

<?php require_once('_footer.php'); ?>