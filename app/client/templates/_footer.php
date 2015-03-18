<?php
use MyECOMM\Login;

if ($this->objUrl->currentPage != 'index'): ?>
                    </div>
            </section>
<?php endif; ?>
        </div>
    </div>
    <footer>
        <div class="footer-row-1">
            <div class="footer-container">
                <div class="footer-block">
                    <div class="footer-cols footer-col-1">
                        <h3>About Us</h3>
                        <ul>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('about'); ?>"
                                    title="Go to About Us"
                                >
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('customer-service'); ?>"
                                    title="Go to Customer Service"
                                >
                                    Customer Service
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('site-map'); ?>"
                                    title="Go to Site Map"
                                >
                                    Site Map
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('sales'); ?>"
                                    title="Go to Orders and Returns"
                                >
                                    Orders and Returns
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('contact'); ?>"
                                    title="Go to Contact"
                                >
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-cols footer-col-2">
                        <h3>Why Buy From Us</h3>
                        <ul>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('shipping'); ?>"
                                    title="Go to Shipping and Returns"
                                >
                                    Shipping and Returns
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('secure-shopping'); ?>"
                                    title="Go to Secure Shopping"
                                >
                                    Secure Shopping
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('international'); ?>"
                                    title="Go to International Shipping"
                                >
                                    International Shipping
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('affiliates'); ?>"
                                    title="Go to Affiliates"
                                >
                                    Affiliates
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('group-sales'); ?>"
                                    title="Go to Group Sales"
                                >
                                    Group Sales
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-cols footer-col-3">
                        <h3>My Account</h3>
                        <ul>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('dashboard'); ?>"
                                    title="Go to My Account"
                                >
                                    My Account
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('wishlist'); ?>"
                                    title="Go to My Wishlist"
                                >
                                    My Wishlist
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('cart'); ?>"
                                    title="Go to My Cart"
                                >
                                    My Cart
                                </a>
                            </li>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('checkout'); ?>"
                                    title="Go to Checkout"
                                >
                                    Checkout
                                </a>
                            </li>
                            <?php if (Login::isLogged(Login::$loginFront)): ?>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('logout'); ?>"
                                    title="Log Out"
                                >
                                    Log Out
                                </a>
                            </li>
                            <?php else: ?>
                            <li>
                                <a
                                    href="<?php echo $this->objUrl->href('login'); ?>"
                                    title="Go to Log In"
                                >
                                    Log In
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="footer-row-2">
            <div class="footer-container">
                <ul>
                    <li class="footer-copyright">
                        <a href="http://www.kostarashev.com"
                           title="Kosta Rashev"
                           target="_blank">
                            <address>
                                &copy;
                                <script type="text/javascript">
                                    var mdate = new Date(); document.write(mdate.getFullYear());
                                </script>
                                Kosta Rashev
                            </address>
                        </a>
                    </li>
                    <li class="footer-github">
                        <a
                            href="https://github.com/kr85"
                            class="pull-right"
                            title="Go to GitHub"
                        >
                            <i class="fa fa-github fa-2x"></i>
                        </a>
                    </li>
                    <li class="footer-linkin">
                        <a
                            href="https://www.linkedin.com/in/kostarashev"
                            class="pull-right"
                            title="Go to LinkedIn"
                        >
                            <i class="fa fa-linkedin-square fa-2x"></i>
                        </a>
                    </li>
                    <li class="footer-google-plus">
                        <a
                            href="https://plus.google.com/116911418217949761063/posts"
                            class="pull-right"
                            title="Go to Google+"
                        >
                            <i class="fa fa-google-plus-square fa-2x"></i>
                        </a>
                    </li>
                    <li class="clearfix"></li>
                </ul>
            </div>
        </div>
    </footer>
    <script src="/assets/main/all-client.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($(location).attr('pathname') == '/') {
                $('.footer-row-1').find('.footer-container').css({"border-top": "none"});
            }
        });
    </script>
</body>
</html>