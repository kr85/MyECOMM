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
    public $metaDescription = 'Books - Online Store';

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
                        PATH_SEPARATOR, [
                            realpath(ADMIN_TEMPLATES_PATH),
                            realpath(ADMIN_PAGES_PATH),
                            get_include_path()
                        ]
                    )
                );
                $this->objAdmin = new Admin();
                $page = ADMIN_PAGES_PATH.DS.$this->objUrl->currentPage.'.php';
                if (file_exists($page)) {
                    @require_once($page);
                } else {
                    @require_once(ADMIN_PAGES_PATH.DS.'error.php');
                }
                break;
            default:
                set_include_path(
                    implode(
                        PATH_SEPARATOR, [
                            realpath(CLIENT_TEMPLATES_PATH),
                            realpath(CLIENT_PAGES_PATH),
                            get_include_path()
                        ]
                    )
                );
                $page = CLIENT_PAGES_PATH.DS.$this->objUrl->currentPage.'.php';
                if (file_exists($page)) {
                    @require_once(CLIENT_PAGES_PATH.DS.$this->objUrl->currentPage.'.php');
                } else {
                    @require_once(CLIENT_PAGES_PATH.DS.'error.php');
                }
        }
        ob_get_flush();
    }
}