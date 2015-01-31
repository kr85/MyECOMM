<?php

    // Checks if a session is set
    if (!isset($_SESSION)) {
        session_start();
    }

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