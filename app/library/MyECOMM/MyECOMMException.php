<?php namespace MyECOMM;

use \Exception;

/**
 * Class MyECOMMException
 *
 * @package MyECOMM
 */
class MyECOMMException extends Exception {

    /**
     * Get the custom exception output based on the environment
     *
     * @param null $e
     * @return null
     */
    public static function getOutput($e = null) {

        if (is_object($e) && ($e instanceof Exception)) {

            if (self::isDevelopment()) {

                $out = [];
                $out[] = 'Message: '.$e->getMessage();
                $out[] = 'File: '.$e->getFile();
                $out[] = 'Line: '.$e->getLine();
                $out[] = 'Code: '.$e->getCode();

                echo '<ul><li>'.implode("</li><li>", $out).'</li></ul>';

                exit();

            } else {

                echo '<p>An error occurred.<br/>';
                echo 'Please contact us explaining what has happened.<br/>';
                echo 'We are sorry for any inconvenience.</p>';

                exit();
            }
        }
        return null;
    }

    /**
     * Check if it is a development environment
     *
     * @return bool
     */
    private static function isDevelopment() {
        return (ENVIRONMENT == 1);
    }
}