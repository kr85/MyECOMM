<?php

    /**
     * Class User
     */
    class User extends Application {

        // Users table name
        private $table = "clients";

        // User id
        public $id;

        /**
         * Check if the user exist
         *
         * @param $email
         * @param $password
         * @return bool
         */
        public function isUser($email, $password) {

            $password = Login::stringToHash($password);

            $sql = "SELECT * FROM `{$this->table}`
                  WHERE `email` = '" . $this->db->escape($email) . "'
                  AND `password` = '" . $this->db->escape($password) . "'
                  AND `active` = 1";

            $result = $this->db->fetchOne($sql);

            if (!empty($result)) {
                $this->id = $result['id'];

                return true;
            }

            return false;
        }

        /**
         * Add user and send confirmation email
         *
         * @param null $parameters
         * @param null $password
         * @return bool
         */
        public function addUser($parameters = null, $password = null) {

            if (!empty($parameters) && !empty($password)) {

                $this->db->prepareInsert($parameters);

                if ($this->db->insert($this->table)) {

                    $objEmail = new Email();
                    $email = [
                        'email'      => $parameters['email'],
                        'first_name' => $parameters['first_name'],
                        'last_name'  => $parameters['last_name'],
                        'password'   => $password,
                        'hash'       => $parameters['hash']
                    ];

                    if ($objEmail->process(1, $email)) {
                        return true;
                    }

                    return false;
                }

                return false;
            }

            return false;
        }

        /**
         * Get user by hash
         *
         * @param null $hash
         * @return mixed
         */
        public function getUserByHash($hash = null) {

            if (!empty($hash)) {

                $sql = "SELECT * FROM `{$this->table}`
                      WHERE `hash` = '" . $this->db->escape($hash) . "'";

                return $this->db->fetchOne($sql);
            }
        }

        /**
         * Activate user account
         *
         * @param null $id
         * @return resource
         */
        public function activate($id = null) {

            if (!empty($id)) {

                $sql = "UPDATE `{$this->table}`
                      SET `active` = 1
                      WHERE `id` = '" . $this->db->escape($id) . "'";

                return $this->db->query($sql);
            }
        }

        /**
         * Get user by email
         *
         * @param null $email
         * @return mixed
         */
        public function getByEmail($email = null) {

            if (!empty($email)) {

                $sql = "SELECT * FROM `{$this->table}`
                      WHERE `email` = '" . $this->db->escape($email) . "'
                      AND `active` = 1";

                return $this->db->fetchOne($sql);
            }
        }

        /**
         * Get user by id
         *
         * @param null $id
         * @return mixed
         */
        public function getUser($id = null) {

            if (!empty($id)) {

                $sql = "SELECT * FROM `{$this->table}`
                      WHERE `id` = '" . $this->db->escape($id) . "'";

                return $this->db->fetchOne($sql);
            }
        }

        /**
         * Update user
         *
         * @param null $parameters
         * @param null $id
         * @return bool
         */
        public function updateUser($parameters = null, $id = null) {

            if (!empty($parameters) && !empty($id)) {

                $this->db->prepareUpdate($parameters);

                if ($this->db->update($this->table, $id)) {
                    return true;
                }

                return false;
            }
        }
    }