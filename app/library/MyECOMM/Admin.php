<?php namespace MyECOMM;

/**
 * Class Admin
 */
class Admin extends Application {

    /**
     * @var string The table name
     */
    protected $table = 'admins';

    /**
     * Check if it a user by email/password
     *
     * @param null $email
     * @param null $password
     * @return bool
     */
    public function isUser($email = null, $password = null) {
        if (!$this->isEmailPasswordEmpty($email, $password)) {
            $password = Login::stringToHash($password);
            $sql = "SELECT *
                    FROM `{$this->table}`
                    WHERE `email` = ?
                    AND `password` = ?";
            $result = $this->Db->fetchOne($sql, [$email, $password]);
            if (!empty($result)) {
                $this->id = $result['id'];
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Check if email and password are empty
     *
     * @param null $email
     * @param null $password
     * @return bool
     */
    private function isEmailPasswordEmpty($email = null, $password = null) {
        return (empty($email) || empty($password));
    }

    /**
     * Get admin's information by id
     *
     * @param null $id
     * @return mixed|null
     */
    public function getAdmin($id = null) {
        if (!empty($id)) {
            $sql = "SELECT *
                    FROM `{$this->table}`
                    WHERE `id` = ?";
            return $this->Db->fetchOne($sql, $id);
        }
        return null;
    }

    /**
     * Get the full name of a registered admin
     *
     * @param null $id
     * @return mixed|null
     */
    public function getFullNameAdmin($id = null) {
        if (!empty($id)) {
            $sql = "SELECT *,
                    CONCAT_WS(' ', `first_name`, `last_name`) AS `full_name`
                    FROM `{$this->table}`
                    WHERE `id` = ?";
            $result = $this->Db->fetchOne($sql, $id);
            if (!empty($result)) {
                return $result['full_name'];
            }
            return null;
        }
        return null;
    }
}