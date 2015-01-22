<?php

/**
 * Class Login
 */
class Login
{
    public static $loginPageFront = "/?page=login";
    public static $dashboardFront = "/?page=orders";
    public static $loginFront = "cid";

    public static $loginPageAdmin = "/admin";
    public static $dashboardAdmin = "/admin/?page=products";
    public static $loginAdmin = "aid";

    public static $validLogin = "valid";

    public static $referrer = "refer";

    /**
     * Convert a string to hash
     *
     * @param null $string
     * @return string
     */
    public static function stringToHash($string = null)
    {
        if (!empty($string))
        {
            return hash('sha512', $string);
        }
    }

    public static function restrictFront()
    {
        if (!self::isLogged(self::$loginFront))
        {
            $url = Url::currentPage() != "logout" ?
                self::$loginPageFront."&".self::$referrer."=".Url::currentPage() :
                self::$loginPageFront;

            Helper::redirect($url);
        }
    }

    public static function isLogged($case = null)
    {
        if (!empty($case))
        {
            if (isset($_SESSION[self::$validLogin])
                && $_SESSION[self::$validLogin] == 1)
            {
                return isset($_SESSION[$case]) ? true : false;
            }

            return false;
        }

        return false;
    }
}