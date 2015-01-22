<?php

/**
 * Class User
 */
class User extends Application
{
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
    public function isUser($email, $password)
    {
        $password = Login::stringToHash($password);
        $sql = "SELECT * FROM `{$this->table}`
                  WHERE `email` = '".$this->db->escape($email)."'
                  AND `password` = '".$this->db->escape($password)."'
                  AND `active` = 1";

        $result = $this->db->fetchOne($sql);

        if (!empty($result))
        {
            $this->id = $result['id'];
            return true;
        }

        return false;
    }
}