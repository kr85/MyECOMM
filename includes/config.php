<?php

    // Checks if a session is set
    if (!isset($_SESSION)) {
        session_start();
    }

    // The country where the business is located
    defined("COUNTRY_LOCAL")
    || define("COUNTRY_LOCAL", 230);

    // Whether the vat should apply to the sales outside of the local country
    defined("INTERNATIONAL_VAT")
    || define("INTERNATIONAL_VAT", false);

    // Page extension
    defined("PAGE_EXTENSION")
        || define("PAGE_EXTENSION", " ");

    // Site domain name with HTTP
    defined("SITE_URL")
        || define("SITE_URL", "http://" . $_SERVER['SERVER_NAME']);

    // Directory separator
    defined("DS")
        || define("DS", DIRECTORY_SEPARATOR);

    // Root path
    defined("ROOT_PATH")
        || define("ROOT_PATH", realpath(dirname(__FILE__) . DS . ".." . DS));

    // Classes folder
    defined("CLASSES_DIR")
        || define("CLASSES_DIR", "classes");

    // Classes path
    defined("CLASSES_PATH")
    || define("CLASSES_PATH", ROOT_PATH . DS. CLASSES_DIR);

    // Plugin folder
    defined("PLUGIN_DIR")
    || define("PLUGIN_DIR", "plugin");

    // Plugin path
    defined("PLUGIN_PATH")
    || define("PLUGIN_PATH", ROOT_PATH . DS. PLUGIN_DIR);

    // Pages folder
    defined("PAGES_DIR")
        || define("PAGES_DIR", "pages");

    // Modules folder
    defined("MODULES_DIR")
        || define("MODULES_DIR", "modules");

    // Includes folder
    defined("INCLUDES_DIR")
        || define("INCLUDES_DIR", "includes");

    // Templates folder
    defined("TEMPLATES_DIR")
        || define("TEMPLATES_DIR", "templates");

    // Emails path
    defined("EMAILS_PATH")
        || define("EMAILS_PATH", ROOT_PATH . DS . "emails");

    // Catalog images path
    defined("CATALOG_PATH")
        || define("CATALOG_PATH", ROOT_PATH . DS . "media" . DS . "catalog");

    // Logs folder
    defined("LOGS_DIR")
        || define("LOGS_DIR", "logs");

    // Add all directories to the include path
    set_include_path(implode(PATH_SEPARATOR, [
        realpath(ROOT_PATH . DS . MODULES_DIR),
        realpath(ROOT_PATH . DS . INCLUDES_DIR),
        get_include_path()
    ]));

    // Require Autoloader file
    require_once(CLASSES_PATH . DS . 'Autoloader.php');
    // Register Autoloader class
    spl_autoload_register(['Autoloader', 'load']);