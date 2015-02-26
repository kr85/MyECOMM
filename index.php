<?php
    // Set default timezone
    date_default_timezone_set('America/Los_Angeles');

    // Checks if a session is set and if it's not then starts a new session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Define environment
    // 0 => production, 1 => development
    defined('ENVIRONMENT')
        || define('ENVIRONMENT', 1);

    // Set error reporting based on environment
    if (ENVIRONMENT == 1) {
        ini_set('display_errors', 'On');
        error_reporting(-1);
    } else {
        ini_set('display_errors', 'Off');
        error_reporting(0);
    }

    // Directory separator
    defined("DS") || define("DS", DIRECTORY_SEPARATOR);

    // Require config file
    require_once('includes'.DS.'config.php');

    // Required custom exception handler
    require_once('MyECOMM'.DS.'MyECOMMException.php');

    // Require Autoloader file
    require_once('MyECOMM'.DS.'Autoloader.php');

    // Set the custom handler
    set_exception_handler(['MyECOMM\MyECOMMException', 'getOutput']);

    // Register Autoloader class
    spl_autoload_register(['MyECOMM\Autoloader', 'load']);

    use MyECOMM\Core;

    $core = new Core();
    $core->run();