<?php

    /**
     * Class Login
     */
    class Login {

        public static $loginPageFront = "/?page=login";
        public static $dashboardFront = "/?page=orders";
        public static $loginFront = "cid";

        public static $loginPageAdmin = "/admin";
        public static $dashboardAdmin = "/admin/?page=products";
        public static $loginAdmin = "aid";

        public static $validLogin = "valid";

        public static $referrer = "refer";

        /**
         * Convert a string to hash
         *
         * @param null $string
         * @return string
         */
        public static function stringToHash($string = null) {

            if (!empty($string)) {
                return hash('sha512', $string);
            }

            return false;
        }

        /**
         * Restrict access only after login
         */
        public static function restrictFront() {

            if (!self::isLogged(self::$loginFront)) {
                $url = Url::currentPage() != "logout" ?
                    self::$loginPageFront . "&" . self::$referrer . "=" .
                        Url::currentPage() :
                    self::$loginPageFront;
                Helper::redirect($url);
            }
        }

        public static function restrictAdmin() {

            if (!self::isLogged(self::$loginAdmin)) {
                Helper::redirect(self::$loginPageAdmin);
            }
        }

        /**
         * Check if user is logged in
         *
         * @param null $case
         * @return bool
         */
        public static function isLogged($case = null) {

            if (!empty($case)) {
                if (isset($_SESSION[self::$validLogin]) &&
                    $_SESSION[self::$validLogin] == 1) {
                    return isset($_SESSION[$case]) ? true : false;
                }

                return false;
            }

            return false;
        }

        /**
         * Login default page
         *
         * @param $id
         * @param null $url
         */
        public static function loginFront($id = null, $url = null) {

            if (!empty($id)) {
                $url = !empty($url) ? $url : self::$dashboardFront;
                $_SESSION[self::$loginFront] = $id;
                $_SESSION[self::$validLogin] = 1;
                Helper::redirect($url);
            }
        }

        public static function loginAdmin($id = null, $url = null) {

            if (!empty($id)) {
                $url = !empty($url) ? $url : self::$dashboardAdmin;
                $_SESSION[self::$loginAdmin] = $id;
                $_SESSION[self::$validLogin] = 1;
                Helper::redirect($url);
            }
        }

        /**
         * Get the full name of the logged in user
         *
         * @param null $id
         * @return string
         */
        public static function getFullNameFront($id = null) {

            if (!empty($id)) {
                $objUser = new User();
                $user = $objUser->getUser($id);
                if (!empty($user)) {
                    return $user['first_name'] . ' ' . $user['last_name'];
                }
            }

            return false;
        }

        /**
         * Logout the user
         *
         * @param null $case
         */
        public static function logout($case = null) {

            if (!empty($case)) {
                $_SESSION[$case] = null;
                $_SESSION[self::$validLogin] = null;
                unset($_SESSION[$case]);
                unset($_SESSION[self::$validLogin]);
            } else {
                session_destroy();
            }
        }
    }