<?php

    /**
     * Class Core
     */
    class Core {

        // Public variables
        public $objUrl;
        public $objNavigation;
        public $metaTitle = 'eCommerce Website';
        public $metaDescription = 'eCommerce Website';
        public $metaKeywords = 'eCommerce Website';

        /**
         * Constructor
         */
        public function __construct() {
            $this->objUrl = new Url();
            $this->objNavigation = new Navigation($this->objUrl);
        }

        /**
         * Run
         */
        public function run() {

            ob_start();

            switch ($this->objUrl->module) {
                case 'panel':
                    set_include_path(implode(PATH_SEPARATOR, [
                        realpath(ROOT_PATH . DS . 'admin' . DS . TEMPLATES_DIR),
                        realpath(ROOT_PATH . DS . 'admin' . DS . PAGES_DIR),
                        get_include_path()
                    ]));
                    require_once(ROOT_PATH . DS . 'admin' . DS . PAGES_DIR .
                        DS . $this->objUrl->currentPage . '.php');
                    break;
                default:
                    set_include_path(implode(PATH_SEPARATOR, [
                        realpath(ROOT_PATH . DS . TEMPLATES_DIR),
                        realpath(ROOT_PATH . DS . PAGES_DIR),
                        get_include_path()
                    ]));
                    require_once(ROOT_PATH . DS . PAGES_DIR .
                        DS . $this->objUrl->currentPage . '.php');
            }

            ob_get_flush();
        }
    }