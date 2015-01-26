<?php

    require_once('config.php');

    /**
     * Autoloader
     *
     * @param $className
     */
    function __autoload($className) {

        $class = explode("_", $className);
        $path = implode("/", $class) . ".php";
        require_once($path);
    }