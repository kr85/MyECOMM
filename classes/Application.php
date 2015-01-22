<?php

/**
 * Class Application
 */
class Application
{
    // Database object
    public $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = new Database();
    }
}