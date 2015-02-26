<?php namespace MyECOMM;

/**
 * Class Autoloader
 */
class Autoloader {

    /**
     * Load
     *
     * @param $className
     */
    public static function load($className) {
        $class = str_replace('\\', DS, ltrim($className, '\\'));
        $class = str_replace('_', DS, $class).'.php';
        @require_once($class);
    }
}