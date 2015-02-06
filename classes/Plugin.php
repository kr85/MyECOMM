<?php

    /**
     * Class Plugin
     */
    class Plugin {

        /**
         * Get a plugin file
         *
         * @param null $file
         * @return bool|string
         */
        public static function get($file = null) {
            // Create a path to the file
            $path = PLUGIN_PATH . DS . $file . '.php';
            // Check if the file and path exist
            if (!empty($file) && is_file($path)) {
                ob_start();
                @include($path);
                return ob_get_clean();
            }
            return false;
        }
    }