<?php

/**
 * Class Application
 */
class Application
{
    public $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = new Database();
    }
}