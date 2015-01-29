<?php

    /**
     * Class Helper
     */
    class Helper {

        /**
         * Encode HTML.
         *
         * @param $string
         * @param int $case
         * @return mixed|string
         */
        public static function encodeHTML($string, $case = 2) {

            switch ($case) {
                case 1:
                    return htmlentities($string, ENT_NOQUOTES, 'UTF-8', false);
                    break;
                case 2:
                    $pattern = '<([a-zA-Z0-9\.\, "\'_\/\-\+~=;:\(\)?&#%![\]@]+)>';
                    // put text only, devided with html tags into array
                    $textMatches = preg_split('/' . $pattern . '/', $string);
                    // array for sanitised output
                    $textSanitised = [];

                    foreach ($textMatches as $key => $value) {
                        $textSanitised[$key] = htmlentities(
                            html_entity_decode($value, ENT_QUOTES, 'UTF-8'),
                            ENT_QUOTES, 'UTF-8');
                    }

                    foreach ($textMatches as $key => $value) {
                        $string = str_replace($value, $textSanitised[$key], $string);
                    }

                    return $string;
                    break;
            }

            return false;
        }

        /**
         * Get the size of a image
         *
         * @param $image
         * @param $case
         * @return mixed
         */
        public static function getImageSize($image, $case) {

            if (is_file($image)) {
                // $case: 0 => width, 1 => height, 2 => type, 3 => attributes
                $size = getimagesize($image);

                return $size[$case];
            }

            return false;
        }

        /**
         * Shorten the description of a product
         *
         * @param $string
         * @param int $length
         * @return string
         */
        public static function shortenString($string, $length = 150) {

            if (strlen($string) > $length) {
                $string = trim(substr($string, 0, $length));
                $string = substr($string, 0, strrpos($string, " "));
                $string .= "&hellip;";
            } else {
                $string .= "&hellip;";
            }

            return $string;
        }

        /**
         * Redirect to url
         *
         * @param null $url
         */
        public static function redirect($url = null) {

            if (!empty($url)) {
                header("Location: {$url}");
                exit;
            }
        }

        /**
         * Set date helper function
         *
         * @param null $case
         * @param null $date
         * @return bool|string
         */
        public static function setDate($case = null, $date = null) {

            $date = empty($date) ? time() : strtotime($date);
            switch ($case) {
                case 1:
                    // 23/01/2015
                    return date('d/m/Y', $date);
                    break;
                case 2:
                    // Monday, 1st January 2015, 10:25:57
                    return date('l, jS F Y, H:i:s', $date);
                    break;
                case 3:
                    // 2015-01-23-10-25-57
                    return date('Y-m-d-H-i-s', $date);
                    break;
                default:
                    // 2015-01-23 10:25:57
                    return date('Y-m-d H:i:s', $date);
            }
        }

        /**
         * Add errors to log file
         *
         * @param null $name
         * @param null $errors
         */
        public static function addToErrorsLog($name = null, $errors = null) {

            if (!empty($name) && empty($errors)) {
                $filePath = LOGS_DIR . DS . $name;
                $file = fopen($filePath, 'w') or die('Unable to open the file.');
                fwrite($file, $name);
                fclose($file);
            }
            if (empty($name) && !empty($errors)) {
                $fileName = date('Y-m-d_H:i:s') . '.log';
                $filePath = LOGS_DIR . DS . $fileName;
                $file = fopen($filePath, 'w') or die('Unable to open the file.');
                fwrite($file, $errors);
                fclose($file);
            }
            if (!empty($name) && !empty($errors)) {
                $fileName = date('Y-m-d_H:i:s_') . $name . '.log';
                $filePath = LOGS_DIR . DS . $fileName;
                $file = fopen($filePath, 'w') or die('Unable to open the file.');
                fwrite($file, $errors);
                fclose($file);
            }
        }

        /**
         * Clean a string from unwanted characters
         *
         * @param null $name
         * @return string
         */
        public static function cleanString($name = null) {
            if (!empty($name)) {
                return strtolower(preg_replace('/[^a-zA-Z0-9.]/', '-', $name));
            }

            return false;
        }

        /**
         * Clear a string
         *
         * @param null $string
         * @param null $remove
         * @return bool|mixed|null
         */
        public static function clearString($string = null, $remove = null) {
            if (!empty($string) && !self::isEmpty($remove)) {
                $remove = self::makeArray($remove);
                foreach ($remove as $key => $value) {
                    $string = str_replace($value, '', $string);
                }

                return $string;
            }

            return false;
        }

        /**
         * Check is a value is empty
         *
         * @param null $value
         * @return bool
         */
        public static function isEmpty($value = null) {
            return empty($value) && !is_numeric($value) ? true : false;
        }

        /**
         * Make an array
         *
         * @param null $array
         * @return array
         */
        public static function makeArray($array = null) {
            return is_array($array) ? $array : [$array];
        }
    }