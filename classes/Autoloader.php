<?php

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
            $class = str_replace('_', DS ,$class) . '.php';
            @require_once(CLASSES_PATH . DS . $class);
        }
    }