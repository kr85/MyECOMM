<?php require_once('private.php');

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
    || define("SITE_URL", "http://".$_SERVER['SERVER_NAME']);

// Root path
defined("ROOT_PATH")
    || define("ROOT_PATH", realpath(dirname(__FILE__).DS."..".DS));

// App folder
defined("APP_DIR")
    || define("APP_DIR", "app");

// App path
defined("APP_PATH")
    || define("APP_PATH", ROOT_PATH.DS.APP_DIR);

// Classes folder
defined("CLASSES_DIR")
    || define("CLASSES_DIR", "library");

// Classes path
defined("CLASSES_PATH")
    || define("CLASSES_PATH", APP_PATH.DS.CLASSES_DIR);

// Plugin folder
defined("PLUGIN_DIR")
    || define("PLUGIN_DIR", "plugin");

// Plugin path
defined("PLUGIN_PATH")
    || define("PLUGIN_PATH", APP_PATH.DS.PLUGIN_DIR);

// Pages folder
defined("PAGES_DIR")
    || define("PAGES_DIR", "pages");

// Client folder
defined("CLIENT_DIR")
    || define("CLIENT_DIR", "client");

// Admin folder
defined("ADMIN_DIR")
    || define("ADMIN_DIR", "admin");

// Client pages folder
defined("CLIENT_PAGES_PATH")
    || define("CLIENT_PAGES_PATH", APP_PATH.DS.CLIENT_DIR.DS.PAGES_DIR);

// Admin pages folder
defined("ADMIN_PAGES_PATH")
    || define("ADMIN_PAGES_PATH", APP_PATH.DS.ADMIN_DIR.DS.PAGES_DIR);

// Modules folder
defined("MODULES_DIR")
    || define("MODULES_DIR", "modules");

// Modules path
defined("MODULES_PATH")
    || define("MODULES_PATH", APP_PATH.DS.MODULES_DIR);

// Includes folder
defined("INCLUDES_DIR")
    || define("INCLUDES_DIR", "includes");

// Includes path
defined("INCLUDES_PATH")
    || define("INCLUDES_PATH", ROOT_PATH.DS.INCLUDES_DIR);

// Templates folder
defined("TEMPLATES_DIR")
    || define("TEMPLATES_DIR", "templates");

// Client templates path
defined("CLIENT_TEMPLATES_PATH")
    || define("CLIENT_TEMPLATES_PATH", APP_PATH.DS.CLIENT_DIR.DS.TEMPLATES_DIR);

// Admin templates path
defined("ADMIN_TEMPLATES_PATH")
    || define("ADMIN_TEMPLATES_PATH", APP_PATH.DS.ADMIN_DIR.DS.TEMPLATES_DIR);

// Emails path
defined("EMAILS_DIR")
    || define("EMAILS_DIR", "emails");

// Emails path
defined("EMAILS_PATH")
    || define("EMAILS_PATH", APP_PATH.DS.EMAILS_DIR);

// Assets dir
defined("ASSETS_DIR")
    || define("ASSETS_DIR", "assets");

// Assets path
defined("ASSETS_PATH")
    || define("ASSETS_PATH", ROOT_PATH.DS.ASSETS_DIR);

// Catalog images folder
defined("CATALOG_DIR")
    || define("CATALOG_DIR", "media".DS."catalog");

// Catalog images path
defined("CATALOG_PATH")
    || define("CATALOG_PATH", ASSETS_PATH.DS.CATALOG_DIR);

// Logs folder
defined("LOGS_DIR")
    || define("LOGS_DIR", "logs");

// SMTP Configs
defined("SMTP_USE")
    || define("SMTP_USE", true);

defined("SMTP_HOST")
    || define("SMTP_HOST", 'smtp.gmail.com');

defined("SMTP_USERNAME")
    || define("SMTP_USERNAME", MAILER_USERNAME);

defined("SMTP_PASSWORD")
    || define("SMTP_PASSWORD", MAILER_PASSWORD);

defined("SMTP_PORT")
    || define("SMTP_PORT", 587);

defined("SMTP_SSL")
    || define("SMTP_SSL", 'tls');

// Database credentials
defined("DB_HOST")
    || define("DB_HOST", 'localhost');

defined("DB_NAME")
    || define("DB_NAME", 'myecomm');

defined("DB_USERNAME")
    || define("DB_USERNAME", 'homestead');

defined("DB_PASSWORD")
    || define("DB_PASSWORD", 'secret');

defined("PAYPAL_BUSINESS_ID")
    || define("PAYPAL_BUSINESS_ID", 'seller-myecomm@gmail.com');

// Composer directory
defined("COMPOSER_DIR")
|| define("COMPOSER_DIR", 'vendor');

// Composer path
defined("COMPOSER_PATH")
    || define("COMPOSER_PATH", ROOT_PATH.DS.COMPOSER_DIR);

// Include composer autoload
if (file_exists(COMPOSER_PATH.DS.'autoload.php')) {
    require(COMPOSER_PATH.DS.'autoload.php');
}

// Add all directories to the include path
set_include_path(
    implode(PATH_SEPARATOR, [
        realpath(INCLUDES_PATH),
        realpath(CLASSES_PATH),
        get_include_path()
    ])
);