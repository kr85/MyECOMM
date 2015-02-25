<?php

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

    // Root path
    defined("ROOT_PATH")
        || define("ROOT_PATH", realpath(dirname(__FILE__).DS."..".DS));

    // Classes folder
    defined("CLASSES_DIR")
        || define("CLASSES_DIR", "library");

    // Classes path
    defined("CLASSES_PATH")
        || define("CLASSES_PATH", ROOT_PATH.DS.CLASSES_DIR);

    // Plugin folder
    defined("PLUGIN_DIR")
        || define("PLUGIN_DIR", "plugin");

    // Plugin path
    defined("PLUGIN_PATH")
        || define("PLUGIN_PATH", ROOT_PATH.DS.PLUGIN_DIR);

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
        || define("EMAILS_PATH", ROOT_PATH.DS."emails");

    // Catalog images folder
    defined("CATALOG_DIR")
        || define("CATALOG_DIR", "media".DS."catalog");

    // Catalog images path
    defined("CATALOG_PATH")
        || define("CATALOG_PATH", ROOT_PATH.DS.CATALOG_DIR);

    // Logs folder
    defined("LOGS_DIR")
        || define("LOGS_DIR", "logs");

    // SMTP Configs
    defined("SMTP_USE")
        || define("SMTP_USE", false);

    defined("SMTP_HOST")
        || define("SMTP_HOST", '');

    defined("SMTP_USERNAME")
        || define("SMTP_USERNAME", '');

    defined("SMTP_PASSWORD")
        || define("SMTP_PASSWORD", '');

    defined("SMTP_PORT")
        || define("SMTP_PORT", '');

    defined("SMTP_SSL")
        || define("SMTP_SSL", '');

    // Database credentials
    defined("DB_HOST")
        || define("DB_HOST", 'localhost');

    defined("DB_NAME")
        || define("DB_NAME", 'myecomm');

    defined("DB_USERNAME")
        || define("DB_USERNAME", 'homestead');

    defined("DB_PASSWORD")
        || define("DB_PASSWORD", 'secret');

    // Add all directories to the include path
    set_include_path(
        implode(PATH_SEPARATOR, [
            realpath(ROOT_PATH.DS.INCLUDES_DIR),
            realpath(CLASSES_PATH),
            get_include_path()
        ])
    );