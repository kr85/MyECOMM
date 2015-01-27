<?php

    /**
     * Class Country
     */
    class Country extends Application {

        private $table = 'countries';

        /**
         * Get all countries
         *
         * @return array
         */
        public function getCountries() {

            $sql = "SELECT * FROM `{$this->table}`
                   ORDER BY `name` ASC";

            return $this->db->fetchAll($sql);
        }

        /**
         * Get country by id
         *
         * @param null $id
         * @return mixed
         */
        public function getCountry($id = null) {

            if (!empty($id)) {
                $sql = "SELECT * FROM `{$this->table}`
                      WHERE `id` = '" . $this->db->escape($id) . "'";

                return $this->db->fetchOne($sql);
            }

            return false;
        }
    }