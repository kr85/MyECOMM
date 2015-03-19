<?php

use MyECOMM\Login;
use MyECOMM\User;
use MyECOMM\Catalog;
use MyECOMM\Session;
use MyECOMM\Helper;
use MyECOMM\Paging;
use MyECOMM\Basket;

// Restrict access only for logged in users
Login::restrictFront($data['objUrl']);

$objUser = new User();
$user = $objUser->getUser(Session::getSession(Login::$loginFront));

if (!empty($user)):

    $objCatalog = new Catalog();
    $wishlist = $objCatalog->getClientWishlist($user['id']);
    $productsCount = count($wishlist);
    $productsPerPage = 5;
    $objPaging = new Paging($data['objUrl'], $wishlist, $productsPerPage);
    $rows = $objPaging->getRecords();
    $productsOnPage = count($rows);
    $page = $data['objUrl']->get('pg');
    $page = (empty($page)) ? 1 : intval($page);

    if (!empty($rows)): ?>
        <div class="wishlist">
            <div class="page-title">
                <h1>Wishlist</h1>
            </div>
            <div>
                <div class="toolbar">
                    <div class="pager">
                        <p class="amount">
                            <?php
                            echo $objCatalog->getPagerAmountText(
                                $page, $productsCount, $productsPerPage, $productsOnPage
                            );
                            ?>
                        </p>
                        <div class="page-number">
                            <label for="page-num"><strong>Page: </strong></label>
                            <div class="input-box">
                                <input
                                    id="page-num"
                                    onfocus="this.blur()"
                                    type="text"
                                    value="<?php echo $page; ?>"
                                    readonly="readonly"
                                    />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="pages">
                            <?php if ($productsCount != 0): ?>
                                <?php echo $objPaging->getPaging(); ?>
                            <?php endif; ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <fieldset>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="center" rowspan="1">&nbsp;</th>
                                <th class="center" rowspan="1">
                                    <span class="nobr">Product Name</span>
                                </th>
                                <th class="center" rowspan="1">
                                    <span class="nobr">Unit Price</span>
                                </th>
                                <th class="center" rowspan="1">
                                    <span class="nobr">Date Added</span>
                                </th>
                                <th class="center" rowspan="1">
                                    <span class="nobr">Remove Product</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows as $item):
                                $product = $objCatalog->getProduct($item['product']);
                                $image = (!empty($product['image'])) ?
                                    $product['image'] :
                                    'unavailable.png';

                                $imageSize = Helper::setImageSize(CATALOG_PATH.DS.$image, 60, 90);

                                $link = $data['objUrl']->href('catalog-item', [
                                    'item',
                                    $product['identity']
                                ]);
                                ?>
                                <tr>
                                    <td class="center">
                                        <a
                                            href="<?php echo $link; ?>"
                                            title="<?php echo Helper::encodeHTML($product['name']); ?>"
                                            >
                                            <img
                                                src="<?php echo DS.ASSETS_DIR.DS.CATALOG_DIR.DS.$image; ?>"
                                                alt="<?php echo Helper::encodeHTML($product['name']); ?>"
                                                width="<?php echo $imageSize['width']; ?>"
                                                height="<?php echo $imageSize['height']; ?>"
                                                />
                                        </a>
                                    </td>
                                    <td class="center">
                                        <h2 class="product-name">
                                            <a
                                                href="<?php echo $link; ?>"
                                                title="<?php echo Helper::encodeHTML($product['name']); ?>"
                                                >
                                                <?php echo Helper::encodeHTML($product['name']); ?>
                                            </a>
                                        </h2>
                                    </td>
                                    <td class="center">
                                        <span class="cart-price">
                                            <span class="price">
                                                <?php
                                                echo $data['objCurrency']->display(
                                                    number_format($product['price'], 2)
                                                );
                                                ?>
                                            </span>
                                        </span>
                                    </td>
                                    <td class="center">
                                        <span class="date-added">
                                            <?php echo Helper::setDate(4, $item['date']); ?>
                                        </span>
                                    </td>
                                    <td class="center">
                                        <?php echo Basket::removeButtonWishlist($item['id']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </fieldset>
                <div class="toolbar">
                    <div class="pager">
                        <p class="amount">
                            <?php
                            echo $objCatalog->getPagerAmountText(
                                $page, $productsCount, $productsPerPage, $productsOnPage
                            );
                            ?>
                        </p>
                        <div class="page-number">
                            <label for="page-num"><strong>Page: </strong></label>
                            <div class="input-box">
                                <input
                                    id="page-num"
                                    onfocus="this.blur()"
                                    type="text"
                                    value="<?php echo $page; ?>"
                                    readonly="readonly"
                                    />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="pages">
                            <?php if ($productsCount != 0): ?>
                                <?php echo $objPaging->getPaging(); ?>
                            <?php endif; ?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
    <div class="center">
        <div class="page-title">
            <h1>Wishlist is Empty</h1>
        </div>
        <p class="empty">
            You have <strong>no items</strong> in your wishlist.<br/>
            Click <a href="/">here</a> to continue shopping.
        </p>
    </div>
</div>
<?php endif;
else:
    Helper::redirect($data['objUrl']->href('error'));
endif; ?>