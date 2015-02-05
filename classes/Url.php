<?php

    /**
     * Class Url
     */
    class Url {

        // Public variables
        public $keyPage = 'page';
        public $keyModules = ['panel'];
        public $module = 'front';
        public $main = 'index';
        public $currentPage = 'index';
        public $action = 'index';
        public $controller = 'login';
        public $parameters = [];
        public $rawParameters = [];
        public $rawString;

        /**
         * Constructor
         */
        public function __construct() {
            $this->process();
        }

        /**
         * Process the URL
         */
        public function process() {
            $uri = $_SERVER['REQUEST_URI'];

            // Check if the URI is empty
            if (!empty($uri)) {
                $uriCount = explode('?', $uri);
                $uri = $uriCount[0];

                // Check if the URI count is greater than 1
                if (count($uriCount) > 1) {
                    $this->rawString = $uriCount[1];
                    $uriRow = explode('&', $uriCount[1]);

                    // Check if the count of uriRow is greater than 1
                    if (count($uriRow) > 1) {
                        foreach ($uriRow as $key => $row) {
                            $this->splitRaw($row);
                        }
                    } else {
                        $this->splitRaw($uriRow);
                    }
                }

                // Remove the file extension from the URI
                $uri = Helper::clearString($uri, PAGE_EXTENSION);

                // Store the first character of the URI and check if it is a '/'
                $firstChar = substr($uri, 0, 1);
                if ($firstChar == '/') {
                    $uri = substr($uri, 1);
                }

                // Store the last character of the URI and check if it is a '/'
                $lastChar = substr($uri, -1);
                if ($lastChar == '/') {
                    $uri = substr($uri, 0, -1);
                }

                // Check if the URI is empty
                if (!empty($uri)) {
                    $uri = explode('/', $uri);
                    $first = array_shift($uri);

                    // Check if the first element is in the keyModules array
                    if (in_array($first, $this->keyModules)) {
                        $this->module = $first;
                        $first = empty($uri) ? $this->main : array_shift($uri);
                    }

                    // Store the first element to the main and currentPage
                    $this->main = $first;
                    $this->currentPage = $this->main;

                    // Check if the URI array has more than one indexes
                    if (count($uri) > 1) {
                        $pairs = [];
                        foreach ($uri as $key => $value) {
                            $pairs[] = $value;
                            if (count($pairs) > 1) {
                                if (!Helper::isEmpty($pairs[1])) {
                                    if ($pairs[0] == $this->keyPage) {
                                        $this->currentPage = $pairs[1];
                                    } else if ($pairs[0] == 'c') {
                                        $this->controller = $pairs[1];
                                    } else if ($pairs[0] == 'a') {
                                        $this->action = $pairs[1];
                                    }
                                    // Store the element at the parameters array
                                    $this->parameters[$pairs[0]] = $pairs[1];
                                }
                                // Reset pairs array
                                $pairs = [];
                            }
                        }
                    }
                }
            }
        }

        /**
         * Split raw item
         *
         * @param null $item
         */
        public function splitRaw($item = null) {
            if (!empty($item) && !is_array($item)) {
                $itemRaw = explode('=', $item);
                if (count($itemRaw) > 1 && !Helper::isEmpty($itemRaw[1])) {
                    $this->rawParameters[$itemRaw[0]] = $itemRaw[1];
                }
            }
        }

        /**
         * Get a parameter from raw parameters array
         *
         * @param null $param
         * @return mixed
         */
        public function getRaw($param = null) {
            if (!empty($param) &&
                array_key_exists($param, $this->rawParameters)) {
                return $this->rawParameters[$param];
            }
            return false;
        }

        /**
         * Get a parameter from parameters array
         *
         * @param null $param
         * @return bool
         */
        public function get($param = null) {
            if (!empty($param) &&
                array_key_exists($param, $this->parameters)) {
                return $this->parameters[$param];
            }
            return false;
        }

        /**
         * Create the href string
         *
         * @param null $main
         * @param null $params
         * @return bool|string
         */
        public function href($main = null, $params = null) {
            if (!empty($main)) {
                $out = [$main];
                if (!empty($params) && is_array($params)) {
                    foreach ($params as $key => $value) {
                        $out[] = $value;
                    }
                }
                return '/' . implode('/', $out) . PAGE_EXTENSION;
            }
            return false;
        }

        /**
         * Get the current URL
         *
         * @param null $exclude
         * @param bool $extension
         * @param null $add
         * @return string
         */
        public function getCurrent($exclude = null, $extension = false, $add = null) {
            $out = [];
            if ($this->module != 'front') {
                $out[] = $this->module;
            }
            $out[] = $this->main;
            if (!empty($this->parameters)) {
                if (!empty($exclude)) {
                    $exclude = Helper::makeArray($exclude);
                    foreach ($this->parameters as $key => $value) {
                        if (!in_array($key, $exclude)) {
                            $out[] = $key;
                            $out[] = $value;
                        }
                    }
                } else {
                    foreach ($this->parameters as $key => $value) {
                        $out[] = $key;
                        $out[] = $value;
                    }
                }
            }
            if (!empty($add)) {
                $add = Helper::makeArray($add);
                foreach ($add as $item) {
                    $out[] = $item;
                }
            }
            $url = '/' . implode('/', $out);
            $url .= $extension ? PAGE_EXTENSION : null;
            return $url;
        }
    }