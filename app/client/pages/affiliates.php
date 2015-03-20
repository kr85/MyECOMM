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
                            Affiliates
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="description-wrapper">
                <div class="page-title">
                    <h2>Affiliates</h2>
                </div>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam
                    mattis, urna quis tempor efficitur, mauris neque tristique
                    ipsum, ac pharetra felis ligula sed neque. Sed egestas dui
                    odio, sed vulputate leo placerat nec. Sed pharetra id ex a
                    malesuada. Mauris vitae quam ornare, ullamcorper neque quis,
                    luctus urna. Proin eu mauris a leo placerat molestie ut ut
                    leo. Suspendisse ornare sagittis augue, sed iaculis mi
                    ullamcorper nec. Duis ac justo non nunc sodales egestas.
                    Donec cursus rhoncus leo vitae dapibus. Sed id volutpat nulla,
                    rhoncus sollicitudin felis. Phasellus vel eros laoreet diam
                    ultrices venenatis. Praesent pharetra quis tellus sed lacinia.
                    In fringilla viverra neque.
                </p>
                <p>
                    Suspendisse potenti. Nam quis turpis enim. Duis at facilisis
                    turpis. Pellentesque elit ante, condimentum non convallis
                    venenatis, interdum sit amet orci. Integer viverra, ante
                    sollicitudin mattis facilisis, ante justo lobortis leo, id
                    vulputate nisl neque eget nunc. Mauris luctus risus mauris,
                    dapibus condimentum quam fringilla at. In tellus ipsum,
                    mattis et felis at, sagittis accumsan risus. Interdum et
                    malesuada fames ac ante ipsum primis in faucibus. Sed
                    consectetur ullamcorper tempor. Phasellus pharetra in massa
                    eu luctus. Etiam quis gravida lacus. Sed facilisis turpis
                    ut lectus tincidunt, non malesuada lectus gravida. Nulla
                    euismod velit id placerat facilisis. Vestibulum id auctor
                    turpis.
                </p>
                <p>
                    Phasellus viverra ipsum ante, sed placerat lacus convallis
                    non. Cras ac risus et sapien suscipit suscipit. Aenean eros
                    magna, egestas hendrerit metus eu, dapibus interdum nisi.
                    Duis sit amet urna facilisis, euismod dui a, sollicitudin
                    lorem. Vivamus placerat lacus condimentum, varius augue non,
                    feugiat ipsum. Aenean elementum ullamcorper imperdiet.
                    Aenean rhoncus rhoncus rhoncus. Proin sollicitudin, neque
                    at hendrerit lacinia, sapien elit pellentesque erat, ut
                    iaculis sem lacus sed odio. Ut iaculis, arcu id aliquet
                    blandit, massa justo ultricies risus, sed sagittis nulla
                    eros id urna. Praesent tortor mauris, commodo at placerat
                    ac, hendrerit in lectus. Aenean dictum libero at nisi
                    lobortis tristique. Vestibulum tempus feugiat hendrerit.
                    Sed scelerisque fermentum ipsum.
                </p>
            </div>
        </div>
        <div class="col-right sidebar">
            <?php echo Plugin::get('front'.DS.'catalog_sidebar', [
                'objUrl'        => $this->objUrl,
                'objCurrency'   => $this->objCurrency,
                'objCatalog'    => $objCatalog,
                'listing'       => 'category',
                'id'            => 0,
                'productId'     => 0,
                'dashboard'     => false
            ]); ?>
        </div>
    </div>

<?php require_once('_footer.php'); ?>