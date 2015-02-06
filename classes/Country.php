<?php

    /**
     * Class Country
     */
    class Country extends Application {

        // The table name
        private $table = 'countries';

        /**
         * Get all countries
         *
         * @return array
         */
        public function getCountries() {

            $sql = "SELECT *
                    FROM `{$this->table}`
                    WHERE `include` = 1
                    ORDER BY `name` ASC";

            return $this->db->fetchAll($sql);
        }

        /**
         * Get a list of all countries except the local ones
         *
         * @return array
         */
        public function getAllExceptLocal() {

            $sql = "SELECT *
                    FROM `{$this->table}`
                    WHERE `id` != " . COUNTRY_LOCAL . "
                    ORDER BY `name` ASC";

            return $this->db->fetchAll($sql);
        }

        /**
         * Get a list of all countries
         *
         * @return array
         */
        public function getAll() {

            $sql = "SELECT *
                    FROM `{$this->table}`
                    ORDER BY `name` ASC";

            return $this->db->fetchAll($sql);
        }

        /**
         * Get a country by id
         *
         * @param null $id
         * @return mixed|null
         */
        public function getOne($id = null) {

            if (!empty($id)) {
                $sql = "SELECT *
                        FROM `{$this->table}`
                        WHERE `id` =" . intval($id);

                return $this->db->fetchOne($sql);
            }

            return null;
        }

        /**
         * Get country by id
         *
         * @param null $id
         * @return mixed
         */
        public function getCountry($id = null) {

            if (!empty($id)) {
                $sql = "SELECT *
                        FROM `{$this->table}`
                        WHERE `id` = '" . intval($id) . "'
                        AND `include` = 1";

                return $this->db->fetchOne($sql);
            }

            return false;
        }
    }