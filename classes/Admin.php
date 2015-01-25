<?php

class Admin extends Application
{
    private $table = 'admins';
    public $id;

    public function isUser($email = null, $password = null)
    {
        if (!empty($email) && !empty($password))
        {
            $password = Login::stringToHash($password);

            $sql = "SELECT * FROM `{$this->table}`
                      WHERE `email` = '".$this->db->escape($email)."'
                      AND `password` = '".$this->db->escape($password)."'";

            $result = $this->db->fetchOne($sql);

            if (!empty($result))
            {
                $this->id = $result['id'];
                return true;
            }

            return false;
        }
    }
}