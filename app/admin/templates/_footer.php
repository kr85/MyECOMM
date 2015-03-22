                </div>
                <?php if ($this->objUrl->currentPage != 'index'): ?>
                <div class="col-right sidebar">
                    <div class="block block-nav">
                        <div class="block-title">
                            <strong>
                                <span>Navigation</span>
                            </strong>
                        </div>
                        <div class="block-content">
                            <ul>
                                <li>
                                    <a href="/panel/dashboard"
                                        <?php echo $this->objNavigation->active(
                                            'dashboard'
                                        ); ?>> Dashboard </a>
                                </li>
                                <li>
                                    <a href="/panel/sections"
                                        <?php echo $this->objNavigation->active(
                                            'sections'
                                        ); ?>> Sections </a>
                                </li>
                                <li>
                                    <a href="/panel/categories"
                                        <?php echo $this->objNavigation->active(
                                            'categories'
                                        ); ?>> Categories </a>
                                </li>
                                <li>
                                    <a href="/panel/products"
                                        <?php echo $this->objNavigation->active(
                                            'products'
                                        ); ?>> Products </a>
                                </li>
                                <li>
                                    <a href="/panel/orders"
                                        <?php echo $this->objNavigation->active(
                                            'orders'
                                        ); ?>> Orders </a>
                                </li>
                                <li>
                                    <a href="/panel/clients"
                                        <?php echo $this->objNavigation->active(
                                            'clients'
                                        ); ?>> Clients </a>
                                </li>
                                <li>
                                    <a href="/panel/business"
                                        <?php echo $this->objNavigation->active(
                                            'business'
                                        ); ?>> Business </a>
                                </li>
                                <li>
                                    <a href="/panel/shipping"
                                        <?php echo $this->objNavigation->active(
                                            'shipping'
                                        ); ?>> Shipping </a>
                                </li>
                                <li>
                                    <a href="/panel/zone"
                                        <?php echo $this->objNavigation->active(
                                            'zone'
                                        ); ?>> Zones </a>
                                </li>
                                <li>
                                    <a href="/panel/country"
                                        <?php echo $this->objNavigation->active(
                                            'country'
                                        ); ?>> Countries </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php endif; ?>
                </div>
            </div>
        </section>
        <div class="push"></div>
    </div>
    <footer>
        <div class="container-footer">
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
        </div>
    </footer>
    <script src="/assets/main/all-admin.js" type="text/javascript"></script>
</body>
</html>