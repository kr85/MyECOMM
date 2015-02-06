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

        /**
         * Add a new country
         *
         * @param null $data
         * @return bool
         */
        public function add($data = null) {

            if (!empty($data)) {
                $this->db->prepareInsert($data);
                return $this->db->insert($this->table);
            }

            return false;
        }

        /**
         * Update a country by id
         *
         * @param null $data
         * @param null $id
         * @return bool|resource
         */
        public function update($data = null, $id = null) {

            if (!empty($data) && !empty($id)) {
                $this->db->prepareUpdate($data);
                return $this->db->update($data, $id);
            }

            return false;
        }

        /**
         * Remove a country by id
         *
         * @param null $id
         * @return bool|resource
         */
        public function remove($id = null) {

            if (!empty($id)) {
                $sql = "DELETE FROM `{$this->table}`
                        WHERE `id` = " . intval($id);

                return $this->db->query($sql);
            }

            return false;
        }
    }