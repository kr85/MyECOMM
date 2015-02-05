<?php

    /**
     * Class Form
     */
    class Form {

        /**
         * Check if a field is posted
         *
         * @param null $field
         * @return bool
         */
        public function isPost($field = null) {

            if (!empty($field)) {
                if (isset($_POST[$field])) {
                    return true;
                }

                return false;
            } else {
                if (!empty($_POST)) {
                    return true;
                }

                return false;
            }
        }

        /**
         * Get post with field if available
         *
         * @param null $field
         * @return null|string
         */
        public function getPost($field = null) {

            if (!empty($field)) {
                return $this->isPost($field) ? strip_tags($_POST[$field]) : null;
            }

            return null;
        }

        /**
         * Keep select input after refresh
         *
         * @param $field
         * @param $value
         * @param null $default
         * @return null|string
         */
        public function stickySelect($field, $value, $default = null) {

            if ($this->isPost($field) && $this->getPost($field) == $value) {
                return " selected=\"selected\"";
            } else {
                return !empty($default) &&
                    $default == $value ?
                        " selected=\"selected\"" :
                        null;
            }
        }

        /**
         * Keep text input after refresh
         *
         * @param $field
         * @param null $value
         * @return null|string
         */
        public function stickyText($field, $value = null) {

            if ($this->isPost($field)) {
                return stripslashes($this->getPost($field));
            } else {
                return !empty($value) ? $value : null;
            }
        }

        /**
         * Get countries for select option for the form
         *
         * @param null $record
         * @return string
         */
        public function getCountriesSelect($record = null) {

            $objCountry = new Country();
            $countries = $objCountry->getCountries();

            if (!empty($countries)) {

                $out = "<select name=\"country\" id=\"country\" class='sel'>";

                if (empty($record)) {
                    $out .= "<option value=\"\">Select one&hellip;</option>";
                }

                foreach ($countries as $country) {

                    $out .= "<option value=\"";
                    $out .= $country['id'];
                    $out .= "\"";
                    $out .= $this->stickySelect('country', $country['id'], $record);
                    $out .= ">";
                    $out .= $country['name'];
                    $out .= "</option>";
                }

                $out .= "</select>";

                return $out;
            }

            return null;
        }

        /**
         * Get posted fields
         *
         * @param null $expected
         * @return array
         */
        public function getPostArray($expected = null) {

            $out = [];

            if ($this->isPost()) {
                foreach ($_POST as $key => $value) {
                    if (!empty($expected)) {
                        if (in_array($key, $expected)) {
                            $out[$key] = strip_tags($value);
                        }
                    } else {
                        $out[$key] = strip_tags($value);
                    }
                }
            }

            return $out;
        }
    }