<?php

/**
 * Class Url
 */
class Url
{
    public static $_page = "page";
    public static $_folder = PAGES_DIR;
    public static $_params = [];

    /**
     * Get parameters
     *
     * @param $param
     * @return null
     */
    public static function getParam($param)
    {
        return isset($_GET[$param])
            && $_GET[$param] != "" ? $_GET[$param] : null;
    }

    /**
     * Return current page
     *
     * @return string
     */
    public static function currentPage()
    {
        return isset($_GET[self::$_page]) ? $_GET[self::$_page] : 'index';
    }

    /**
     * Gets a page or returns error if it does not exist
     *
     * @return string
     */
    public static function getPage()
    {
        $page = self::$_folder.DS.self::currentPage().".php";
        $error = self::$_folder.DS."error.php";
        return is_file($page) ? $page : $error;
    }

    /**
     * Gets all parameters
     */
    public static function getAll()
    {
        if (!empty($_GET))
        {
            foreach ($_GET as $key => $value)
            {
                if (!empty($value))
                {
                    self::$_params[$key] = $value;
                }
            }
        }
    }
}