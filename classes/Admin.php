<?php

    /**
     * Class Admin
     */
    class Admin extends Application {

        // The table name
        private $table = 'admins';

        public $id;

        /**
         * Check if it a user by email/password
         *
         * @param null $email
         * @param null $password
         * @return bool
         */
        public function isUser($email = null, $password = null) {

            if (!empty($email) && !empty($password)) {

                $password = Login::stringToHash($password);

                $sql = "SELECT * FROM `{$this->table}`
                      WHERE `email` = '" . $this->db->escape($email) . "'
                      AND `password` = '" . $this->db->escape($password) . "'";

                $result = $this->db->fetchOne($sql);

                if (!empty($result)) {
                    $this->id = $result['id'];

                    return true;
                }

                return false;
            }

            return false;
        }
    }