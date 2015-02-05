<?php

    /**
     * Class Database
     */
    class Database {

        // Database connection credentials
        private $hostname;
        private $username;
        private $password;
        private $database;
        private $connDb;

        // Database helper fields
        public $lastQuery = null;
        public $affectedRows = 0;
        public $insertKeys = [];
        public $insertValues = [];
        public $updateSets = [];
        public $id;

        /**
         * Constructor
         */
        public function __construct() {

            $this->hostname = ProjectVariable::$DB_HOSTNAME;
            $this->username = ProjectVariable::$DB_USERNAME;
            $this->password = ProjectVariable::$DB_PASSWORD;
            $this->database = ProjectVariable::$DB_NAME;
            $this->connDb = false;
            $this->connect();
        }

        /**
         * Connect to database
         */
        private function connect() {

            $this->connDb = mysqli_connect(
                $this->hostname,
                $this->username,
                $this->password,
                $this->database
            );

            if (!$this->connDb) {
                die("Database connection failed: <br />" . mysqli_error($this->connDb));
            } else {
                $select = mysqli_select_db($this->connDb, $this->database);
                if (!$select) {
                    die("Database selection failed: <br />" . mysql_error());
                }
            }
            mysqli_set_charset($this->connDb, "utf8");
        }

        /**
         * Check if connection was successfully closed
         */
        public function close() {

            if (!mysqli_close($this->connDb)) {
                die("Closing connection failed.");
            }
        }

        /**
         * Strips slashes from a value
         *
         * @param $value
         * @return string
         */
        public function escape($value) {

            if (function_exists("mysql_real_escape_string")) {
                if (get_magic_quotes_gpc()) {
                    $value = stripslashes($value);
                }
                $value = mysqli_real_escape_string($this->connDb, $value);
            } else {
                if (!get_magic_quotes_gpc()) {
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
        public function query($sql) {

            $this->lastQuery = $sql;
            $result = mysqli_query($this->connDb, $sql);
            $this->displayQuery($result);

            return $result;
        }

        /**
         * Checks if a query was successfully executed
         *
         * @param $result
         */
        public function displayQuery($result) {

            if (!$result) {
                $output = "Database query failed: " . mysqli_error($this->connDb);
                $output .= "Last SQL query was: " . $this->lastQuery;
                //Helper::addToErrorsLog('Query_Errors', $output);
                die($output);
            } else {
                $this->affectedRows = mysqli_affected_rows($this->connDb);
            }
        }

        /**
         * Fetch all rows
         *
         * @param $sql
         * @return array
         */
        public function fetchAll($sql) {

            $result = $this->query($sql);
            $out = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $out[] = $row;
            }
            mysqli_free_result($result);

            return $out;
        }

        /**
         * Fetch only first row
         *
         * @param $sql
         * @return mixed
         */
        public function fetchOne($sql) {

            $out = $this->fetchAll($sql);

            return array_shift($out);
        }

        /**
         * Get last inserted id
         *
         * @return int
         */
        public function lastId() {

            return mysqli_insert_id($this->connDb);
        }

        /**
         * Prepare parameters for insert query
         *
         * @param null $parameters
         */
        public function prepareInsert($parameters = null) {

            if (!empty($parameters)) {
                foreach ($parameters as $key => $value) {
                    $this->insertKeys[] = $key;
                    $this->insertValues[] = $this->escape($value);
                }
            }
        }

        /**
         * Insert SQL query
         *
         * @param null $table
         * @return bool
         */
        public function insert($table = null) {

            if (!empty($this) &&
                !empty($this->insertKeys) &&
                !empty($this->insertValues)) {

                $sql = "INSERT INTO `{$table}` (`";
                $sql .= implode("`, `", $this->insertKeys);
                $sql .= "`) VALUES ('";
                $sql .= implode("', '", $this->insertValues);
                $sql .= "')";

                if ($this->query($sql)) {
                    $this->id = $this->lastId();

                    return true;
                }

                return false;
            }

            return false;
        }

        /**
         * Prepare parameters for update query
         *
         * @param null $parameters
         */
        public function prepareUpdate($parameters = null) {

            if (!empty($parameters)) {
                foreach ($parameters as $key => $value) {
                    $this->updateSets[] = "`{$key}` = '" . $this->escape($value) . "'";
                }
            }
        }

        /**
         * Update SQL query
         *
         * @param null $table
         * @param null $id
         * @return resource
         */
        public function update($table = null, $id = null) {

            if (!empty($table) && !empty($id) && !empty($this->updateSets)) {
                $sql = "UPDATE `{$table}` SET ";
                $sql .= implode(", ", $this->updateSets);
                $sql .= " WHERE `id` = '" . $this->escape($id) . "'";

                return $this->query($sql);
            }

            return false;
        }
    }
