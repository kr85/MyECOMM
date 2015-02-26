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
                    AND `password` = '" . $this->db->escape(
                    $password
                ) . "'";

            $result = $this->db->fetchOne($sql);

            if (!empty($result)) {
                $this->id = $result['id'];

                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Get admin's information by id
     *
     * @param null $id
     * @return bool|mixed
     */
    public function getAdmin($id = null) {

        if (!empty($id)) {
            $sql = "SELECT * FROM `{$this->table}`
                    WHERE `id` = '" . $this->db->escape($id) . "'";

            return $this->db->fetchOne($sql);
        }

        return false;
    }

    /**
     * Get the full name of a registered admin
     *
     * @param null $id
     * @return bool
     */
    public function getFullNameAdmin($id = null) {
        if (!empty($id)) {
            $sql = "SELECT *,
                    CONCAT_WS(' ', `first_name`, `last_name`) AS `full_name`
                    FROM `{$this->table}`
                    WHERE `id` = " . intval($id);
            $result = $this->db->fetchOne($sql);
            if (!empty($result)) {
                return $result['full_name'];
            }
        }
        return false;
    }
}