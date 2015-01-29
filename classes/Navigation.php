<?php

    /**
     * Class Navigation
     */
    class Navigation {

        // Public variables
        public $objUrl;
        public $classActive = 'active';

        /**
         * Constructor
         *
         * @param null $objUrl
         */
        public function __construct($objUrl = null) {
            $this->objUrl = is_object($objUrl) ? $objUrl : new Url();
        }

        /**
         * Return the active class
         *
         * @param null $main
         * @param null $pairs
         * @param null $single
         * @return bool|string
         */
        public function active($main = null, $pairs = null, $single = null ) {
            if (!empty($main)) {
                if (!empty($pairs)) {
                    if ($main == $this->objUrl->main) {
                        return !$single ?
                            ' ' . $this->classActive :
                            ' class="' . $this->classActive . '"';
                    }
                } else {
                    $exceptions = [];
                    foreach ($pairs as $key => $value) {
                        $paramUrl = $this->objUrl->get($key);
                        if ($paramUrl != $value) {
                            $exceptions[] = $key;
                        }
                    }
                    if ($main == $this->objUrl->main && empty($exceptions)) {
                        return !$single ?
                            ' ' . $this->classActive :
                            ' class="' . $this->classActive . '"';
                    }
                }
            }
            return false;
        }
    }