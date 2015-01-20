<?php

/**
 * Class Url
 */
class Url
{
    public static $page = "page";
    public static $folder = PAGES_DIR;
    public static $params = [];

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
        return isset($_GET[self::$page]) ? $_GET[self::$page] : 'index';
    }

    /**
     * Gets a page or returns error if it does not exist
     *
     * @return string
     */
    public static function getPage()
    {
        $page = self::$folder.DS.self::currentPage().".php";
        $error = self::$folder.DS."error.php";
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
                    self::$params[$key] = $value;
                }
            }
        }
    }
}