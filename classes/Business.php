<?php

    /**
     * Class Business
     */
    class Business extends Application {

        // The name of the database table
        private $table = 'business';

        /**
         * Get all business information
         *
         * @return mixed
         */
        public function getBusiness() {

            $sql = "SELECT * FROM `{$this->table}` WHERE `id` = 1";

            return $this->db->fetchOne($sql);
        }

        /**
         * Update the business information
         *
         * @param null $data
         * @return bool|resource
         */
        public function updateBusiness($data = null) {

            if (!empty($data)) {
                $this->db->prepareUpdate($data);
                return $this->db->update($this->table, 1);
            }

            return false;
        }

        /**
         * Get tax rate
         *
         * @return mixed
         */
        public function getTaxRate() {

            $business = $this->getBusiness();

            return $business['tax_rate'];
        }
    }