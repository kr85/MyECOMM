<?php

/**
 * Class Database
 */
class Database
{
    private $_hostname = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "ecommerce";

    private $_conndb = false;
    public $_last_query = null;
    public $_affected_rows = 0;

    public $_insert_keys = [];
    public $_insert_values = [];
    public $_update_sets = [];

    public $_id;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Connect to database
     */
    private function connect()
    {
        $this->_conndb = mysql_connect(
            $this->_hostname,
            $this->_username,
            $this->_password
        );

        if (!$this->_conndb)
        {
            die("Database connection failed: <br />" . mysql_error());
        }
        else
        {
            $_select = mysql_select_db(
                $this->_database,
                $this->_conndb
            );

            if (!$_select)
            {
                die("Database selection failed: <br />" . mysql_error());
            }
        }

        mysql_set_charset("utf8", $this->_conndb);
    }

    /**
     * Check if connection was successfully closed
     */
    public function close()
    {
        if (!mysql_close($this->_conndb))
        {
            die("Closing connection failed.");
        }
    }

    /**
     * Strips slashes from a value
     *
     * @param $value
     * @return string
     */
    public function escape($value)
    {
        if (function_exists("mysql_real_escape_string"))
        {
            if (get_magic_quotes_gpc())
            {
                $value = stripslashes($value);
            }

            $value = mysql_real_escape_string($value);
        }
        else
        {
            if (!get_magic_quotes_gpc())
            {
                $value = addslashes($value);
            }
        }

        return $value;
    }

    /**
     * Execute a SQL query
     *
     * @param $sql
     * @return resource
     */
    public function query($sql)
    {
        $this->_last_query = $sql;
        $result = mysql_query($sql, $this->_conndb);
        $this->displayQuery($result);
        return $result;
    }

    /**
     * Checks if a query was successfully executed
     *
     * @param $result
     */
    public function displayQuery($result)
    {
        if (!$result)
        {
            $output = "Database query failed: " . mysql_error();
            $output .= "Last SQL query was: " . $this->_last_query;
            die($output);
        }
        else
        {
            $this->_affected_rows = mysql_affected_rows($this->_conndb);
        }
    }

    /**
     * Fetch all rows
     *
     * @param $sql
     * @return array
     */
    public function fetchAll($sql)
    {
        $result = $this->query($sql);
        $out = [];
        while($row = mysql_fetch_assoc($result))
        {
            $out[] = $row;
        }

        mysql_free_result($result);
        return $out;
    }

    /**
     * Fetch only first row
     *
     * @param $sql
     * @return mixed
     */
    public function fetchOne($sql)
    {
        $out = $this->fetchAll($sql);
        return array_shift($out);
    }

    /**
     * Get last inserted id
     *
     * @return int
     */
    public function lastId()
    {
        return mysql_insert_id($this->_conndb);
    }
}