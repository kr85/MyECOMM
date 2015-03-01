<?php namespace MyECOMM\Database\Extension;

use MyECOMM\Database\Database;

/**
 * Class MySQL
 *
 * @package MyECOMM\Database\Extension
 */
class MySQL extends  Database {

    /**
     * @var string Database schema
     */
    protected $schema = 'mysql';

    /**
     * @var string Database hostname
     */
    protected $hostname = DB_HOST;

    /**
     * @var string Database name
     */
    protected $database = DB_NAME;

    /**
     * @var string Database username
     */
    protected $username = DB_USERNAME;

    /**
     * @var string Database password
     */
    protected $password = DB_PASSWORD;

    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array = null) {
        // Call prepare function
        $this->prepare($array);
        // Call Database class constructor
        parent::__construct();
    }

    /**
     * Reassign array in case of creating another mysql connection
     * with different connection details
     *
     * @param array $array
     */
    private function prepare(array $array = null) {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}