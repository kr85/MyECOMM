<?php namespace MyECOMM;

/**
 * Class Core
 */
class Core {

    /**
     * @var Url object instance
     */
    public $objUrl;

    /**
     * @var Navigation object instance
     */
    public $objNavigation;

    /**
     * @var Currency object instance
     */
    public $objCurrency;

    /**
     * @var Admin object instance
     */
    public $objAdmin;

    /**
     * @var string Meta title
     */
    public $metaTitle = 'eCommerce Website';

    /**
     * @var string Meta description
     */
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