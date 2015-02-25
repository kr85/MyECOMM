<?php namespace MyECOMM;

/**
 * Class Core
 */
class Core {

    // Public variables
    public $objUrl;
    public $objNavigation;
    public $objCurrency;
    public $objAdmin;
    public $metaTitle = 'eCommerce Website';
    public $metaDescription = 'eCommerce Website';

    /**
     * Constructor
     */
    public function __construct() {
        $this->objUrl = new Url();
        $this->objNavigation = new Navigation($this->objUrl);
        $this->objCurrency = new Currency();
    }

    /**
     * Run
     */
    public function run() {

        ob_start();

        switch ($this->objUrl->module) {
            case 'panel':
                set_include_path(
                    implode(
                        PATH_SEPARATOR,
                        [
                            realpath(
                                ROOT_PATH.DS.'admin'.DS.TEMPLATES_DIR
                            ),
                            realpath(
                                ROOT_PATH.DS.'admin'.DS.PAGES_DIR
                            ),
                            get_include_path()
                        ]
                    )
                );
                $this->objAdmin = new Admin();
                $page = ROOT_PATH.DS.'admin'.DS.PAGES_DIR.DS.$this->objUrl->currentPage.'.php';
                if (file_exists($page)) {
                    @require_once($page);
                } else {
                    @require_once(ROOT_PATH.DS.'admin'.DS.PAGES_DIR.DS.'error.php');
                }
                break;
            default:
                set_include_path(
                    implode(
                        PATH_SEPARATOR,
                        [
                            realpath(ROOT_PATH.DS.TEMPLATES_DIR),
                            realpath(ROOT_PATH.DS.PAGES_DIR),
                            get_include_path()
                        ]
                    )
                );
                $page = ROOT_PATH.DS.PAGES_DIR.DS.$this->objUrl->currentPage.'.php';
                if (file_exists($page)) {
                    @require_once(ROOT_PATH.DS.PAGES_DIR.DS.$this->objUrl->currentPage.'.php');
                } else {
                    @require_once(ROOT_PATH.DS.PAGES_DIR.DS.'error.php');
                }
        }

        ob_get_flush();
    }
}