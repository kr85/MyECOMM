<?php namespace MyECOMM;

/**
 * Class Login
 */
class Login {

    /**
     * @var string Client's login page
     */
    public static $loginPageFront = "/login";

    /**
     * @var string Client's landing dashboard page
     */
    public static $dashboardFront = "/dashboard";

    /**
     * @var string Client id
     */
    public static $loginFront = "cid";

    /**
     * @var string Admin's login page
     */
    public static $loginPageAdmin = "/panel";

    /**
     * @var string Admin's landing dashboard page
     */
    public static $dashboardAdmin = "/panel/products";

    /**
     * @var string Admin id
     */
    public static $loginAdmin = "aid";

    /**
     * @var string Valid login
     */
    private static $validLogin = "valid";

    /**
     * @var string Referrer page
     */
    public static $referrer = "refer";

    /**
     * Convert a string to hash
     *
     * @param null $string
     * @return string
     */
    public static function stringToHash($string = null) {
        if (!empty($string)) {
            return hash('sha512', $string);
        }
        return false;
    }

    /**
     * Restrict access only after login (clients)
     *
     * @param null $objUrl
     */
    public static function restrictFront($objUrl = null) {
        $objUrl = is_object($objUrl) ? $objUrl : new Url();
        if (!self::isLogged(self::$loginFront)) {
            $url = $objUrl->currentPage != 'logout' ?
                self::$loginPageFront.'/'.self::$referrer.'/'.
                    $objUrl->currentPage.PAGE_EXTENSION :
                self::$loginPageFront.PAGE_EXTENSION;
            Helper::redirect($url);
        }
    }

    /**
     * Restrict access only after login (admins)
     */
    public static function restrictAdmin() {
        if (!self::isLogged(self::$loginAdmin)) {
            Helper::redirect(self::$loginPageAdmin);
        }
    }

    /**
     * Check if user is logged in
     *
     * @param null $case
     * @return bool
     */
    public static function isLogged($case = null) {
        if (!empty($case)) {
            if (isset($_SESSION[self::$validLogin]) &&
                $_SESSION[self::$validLogin] == 1
            ) {
                return (isset($_SESSION[$case])) ? true : false;
            }
            return false;
        }
        return false;
    }

    /**
     * Login default page
     *
     * @param $id
     * @param null $url
     */
    public static function loginFront($id = null, $url = null) {
        if (!empty($id)) {
            $url = !empty($url) ? $url : self::$dashboardFront.PAGE_EXTENSION;
            $_SESSION[self::$loginFront] = $id;
            $_SESSION[self::$validLogin] = 1;
            Helper::redirect($url);
        }
    }

    /**
     * Admin login page
     *
     * @param null $id
     * @param null $url
     */
    public static function loginAdmin($id = null, $url = null) {
        if (!empty($id)) {
            $url = (!empty($url)) ? $url : self::$dashboardAdmin;
            $_SESSION[self::$loginAdmin] = $id;
            $_SESSION[self::$validLogin] = 1;
            Helper::redirect($url);
        }
    }

    /**
     * Get the full name of the logged in user
     *
     * @param null $id
     * @return string
     */
    public static function getFullNameFront($id = null) {
        if (!empty($id)) {
            $objUser = new User();
            $user = $objUser->getUser($id);
            if (!empty($user)) {
                return $user['first_name'].' '.$user['last_name'];
            }
        }
        return false;
    }

    /**
     * Get the full name of the logged in admin
     *
     * @param null $id
     * @return bool|string
     */
    public static function getFullNameAdmin($id = null) {
        if (!empty($id)) {
            $objAdmin = new Admin();
            $admin = $objAdmin->getAdmin($id);
            if (!empty($admin)) {
                return $admin['first_name'].' '.$admin['last_name'];
            }
        }
        return false;
    }

    /**
     * Logout the user
     *
     * @param null $case
     */
    public static function logout($case = null) {
        if (!empty($case)) {
            $_SESSION[$case] = null;
            $_SESSION[self::$validLogin] = null;
            unset($_SESSION[$case]);
            unset($_SESSION[self::$validLogin]);
        } else {
            session_destroy();
        }
    }
}