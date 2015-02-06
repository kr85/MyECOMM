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