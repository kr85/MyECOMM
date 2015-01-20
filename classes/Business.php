<?php

/**
 * Class Business
 */
class Business extends Application
{
    private $table = 'business';

    /**
     * Get all business information
     *
     * @return mixed
     */
    public function getBusiness()
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `id` = 1";

        return $this->db->fetchOne($sql);
    }


}