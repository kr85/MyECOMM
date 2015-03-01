<?php namespace MyECOMM\Database;

use \PDO;
use \PDOException;
use MyECOMM\Helper;

/**
 * Class Database
 *
 * @package MyECOMM\Database
 */
abstract class Database {

    /**
     * @var Database schema
     */
    protected $schema;

    /**
     * @var Database hostname
     */
    protected $hostname;

    /**
     * @var Database name
     */
    protected $database;

    /**
     * @var Database username
     */
    protected $username;

    /**
     * @var Database password
     */
    protected $password;

    /**
     * @var bool Persistent connection flag
     */
    private $persistent = true;

    /**
     * @var int Database fetch mode
     */
    private $fetchMode = PDO::FETCH_ASSOC;

    /**
     * @var array List of driver options
     */
    private $driverOptions = [];

    /**
     * @var null Connection string
     */
    private $connectionString = null;

    /**
     * @var PDO object instance
     */
    private $pdoObject = null;

    /**
     * @var Number of affected rows
     */
    public $affectedRows;

    /**
     * @var Id
     */
    public $id;

    /**
     * Constructor
     */
    public function __construct() {
        $this->connect();
    }

    /**
     * Connect to the database
     */
    private function connect() {
        // Set the connection string
        $this->setConnection();
        // Try to create a new database connection
        try {
            $this->pdoObject = new PDO(
                $this->connectionString,
                $this->username,
                $this->password,
                $this->driverOptions
            );
        } catch (PDOException $e) {
            echo $this->exceptionOutput($e,
                'There was a problem with the Database connection.'
            );
        }
    }

    /**
     * Set driver option
     *
     * @param null $key
     * @param null $value
     */
    public function setDriverOption($key = null, $value = null) {
        $this->driverOptions[$key] = $value;
    }

    /**
     * Set the connection string
     */
    private function setConnection() {
        // Set the connection string for each case
        switch ($this->schema) {
            case 'mysql':
                $this->connectionString =
                    "mysql:dbname={$this->database};host={$this->hostname}";
                break;
            case 'sqlite':
                $this->connectionString = "sqlite:{$this->database}";
                break;
            case 'pgsql':
                $this->connectionString =
                    "pgsql:dbname={$this->database};host={$this->hostname}";
                break;
        }
        // Set driver options
        $this->setDriverOption(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
        $this->setDriverOption(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // If connection is persistent set appropriate driver option
        if ($this->persistent) {
            $this->setDriverOption(PDO::ATTR_PERSISTENT, true);
        }
    }

    /**
     * Show exception output based on environment
     *
     * @param null $e
     * @param null $message
     * @return null|string
     */
    private function exceptionOutput($e = null, $message = null) {
        if (is_object($e)) {
            if (ENVIRONMENT == 1) {
                return $e->getMessage();
            } else {
                return '<p>'.$message.'</p>';
            }
        }
        return null;
    }

    /**
     *
     *
     * @param null $sql
     * @param null $params
     * @return null|\PDOStatement
     */
    private function query($sql = null, $params = null) {

        if (!empty($sql)) {
            if (!is_object($this->pdoObject)) {
                $this->connect();
            }
            // Prepare a statement
            $statement = $this->pdoObject->prepare($sql, $this->driverOptions);
            // If there was an error throw an exception
            if (!$statement) {
                $errorInfo = $this->pdoObject->errorInfo();
                throw new PDOException("Database error [{$errorInfo[0]}]:
                    {$errorInfo[2]}, driver error code is {$errorInfo[1]}."
                );
            }
            // An array of the converted parameters
            $paramsConverted = [];
            // Check if the server supports magic quotes
            if (get_magic_quotes_gpc() == true) {
                if (is_array($params)) {
                    foreach ($params as $key => $value) {
                        $paramsConverted[$key] = stripcslashes($value);
                    }
                } else {
                    $paramsConverted[] = stripcslashes($params);
                }
            } else {
                $paramsConverted = is_array($params) ? $params : [$params];
            }
            // If there was an error executing the statement display it
            if (!$statement->execute($paramsConverted) ||
                $statement->errorCode() != '00000'
            ) {
                $errorInfo = $statement->errorInfo();
                throw new PDOException("Database error [{$errorInfo[0]}]:
                    {$errorInfo[2]}, driver error code is {$errorInfo[1]}.<br/>
                    SQL: {$sql}"
                );
            }
            // Store the number of affected rows
            $this->affectedRows = $statement->rowCount();
            // Return the statement
            return $statement;
        }
        return null;
    }

    /**
     * Set fetch mode
     *
     * @param null $fetchMode
     */
    public function setFetchMode($fetchMode = null) {
        if (!empty($fetchMode)) {
            $this->fetchMode = $fetchMode;
        }
    }

    /**
     * Get the last insert id
     *
     * @param null $sequenceName
     * @return mixed
     */
    public function getLastInsertId($sequenceName = null) {
        return $this->pdoObject->lastInsertId($sequenceName);
    }

    /**
     * Fetch all records
     *
     * @param null $sql
     * @param null $params
     * @return mixed
     */
    public function fetchAll($sql = null, $params = null) {
        // Check if a SQL statement was passed
        if (!empty($sql)) {
            try {
                // Call the query function and execute statement fetch all
                $statement = $this->query($sql, $params);
                return $statement->fetchAll($this->fetchMode);
            } catch (PDOException $e) {
                echo $this->exceptionOutput($e,
                    'Something went wrong trying to retrieve the records.'
                );
            }
        }
        return null;
    }

    /**
     * Fetch one record
     *
     * @param null $sql
     * @param null $params
     * @return mixed
     */
    public function fetchOne($sql = null, $params = null) {
        // Check if a SQL statement was passed
        if (!empty($sql)) {
            try {
                // Call the query function and execute statement fetch one
                $statement = $this->query($sql, $params);
                return $statement->fetch($this->fetchMode);
            } catch (PDOException $e) {
                echo $this->exceptionOutput($e,
                    'Something went wrong trying to retrieve the record.'
                );
            }
        }
        return null;
    }

    /**
     * Execute a sql statement with parameters
     *
     * @param null $sql
     * @param null $params
     * @return mixed
     */
    public function execute($sql = null, $params = null) {
        // Check if a SQL statement was passed
        if (!empty($sql)) {
            try {
                // Call the query function with sql and data
                return $this->query($sql, $params);
            } catch (PDOException $e) {
                echo $this->exceptionOutput($e,
                    'Something went wrong when executing the SQL statement.'
                );
            }
        }
        return null;
    }

    /**
     * Prepare insert array
     *
     * @param null $params
     * @param null $pre
     * @return array|bool
     */
    private function insertArray($params = null, $pre = null) {
        // Check if the parameters are valid
        if (!empty($params) && is_array($params)) {
            // Arrays for fields, holders and values
            $fields = [];
            $holders = [];
            $values = [];
            // Reassign the keys and values to fields, holders and values arrays
            foreach ($params as $key => $value) {
                $fields[] = (!empty($pre)) ? "`{$pre}.{$key}`" : "`{$key}`";
                $holders[] = "?";
                $values[] = $value;
            }
            // Return an array with fields, holders and values sub-arrays
            return [$fields, $holders, $values];
        }
        return false;
    }

    /**
     * Prepare the parameters for the update prepared statement
     *
     * @param null $params
     * @param null $pre
     * @return array|bool
     */
    private function updateArray($params = null, $pre = null) {
        // Check if the parameters are valid
        if (!empty($params) && is_array($params)) {
            // Arrays for fields and values
            $fields = [];
            $values = [];
            // Reassign the keys and values to fields and values arrays
            foreach ($params as $key => $value) {
                $fields[] = (!empty($pre)) ? "`{$pre}.{$key}` = ?" : "`{$key}` = ?";
                $values[] = $value;
            }
            // Return an array with fields and values sub-arrays
            return [$fields, $values];
        }
        return false;
    }

    /**
     * Prepared insert statement
     *
     * @param null $table
     * @param null $params
     * @return bool
     */
    public function insert($table = null, $params = null) {
        // Prepare the insert parameters
        $params = $this->insertArray($params);
        // Check if the table and the parameters are valid
        if (!empty($table) && !empty($params)) {
            // SQL statement
            $sql  = "INSERT INTO `{$table}` (";
            $sql .= implode(", ", $params[0]);
            $sql .= ") VALUES (";
            $sql .= implode(", ", $params[1]);
            $sql .= ")";
            // Execute and save the result
            $return = $this->execute($sql, $params[2]);
            // If executing was successful then save the id and return true
            if ($return) {
                $this->id = $this->getLastInsertId();
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Prepared update statement
     *
     * @param null $table
     * @param null $params
     * @param null $value
     * @param string $field
     * @return bool|mixed
     */
    public function update(
        $table = null, $params = null, $value = null, $field = 'id'
    ) {
        // Prepare the update parameters
        $params = $this->updateArray($params);
        // Check if the parameters are valid
        if ($this->areUpdateParametersValid($table, $params, $value, $field)) {
            // SQL statement
            $sql  = "UPDATE `{$table}` SET ";
            $sql .= implode(", ", $params[0]);
            $sql .= " WHERE `{$field}` = ?";
            // Add a new value
            $params[1][] = $value;
            // Execute and return the result
            return $this->execute($sql, $params[1]);
        }
        return false;
    }

    /**
     * Check if the parameters for the update function are valid
     *
     * @param null $table
     * @param null $params
     * @param null $value
     * @param null $field
     * @return bool
     */
    private function areUpdateParametersValid(
        $table = null, $params = null, $value = null, $field = null
    ) {
        return (!empty($table) && !empty($params) &&
            !Helper::isEmpty($value) && !empty($field));
    }

    /**
     * Prepared delete statement
     *
     * @param null $table
     * @param null $value
     * @param string $field
     * @return bool|mixed
     */
    public function delete($table = null, $value = null, $field = 'id') {
        // Check if the parameters are valid
        if ($this->areDeleteParametersValid($table, $value, $field)) {
            // SQL Statement
            $sql = "DELETE FROM `{$table}`
                    WHERE `$field` = ?";
            // Execute and return the result
            return $this->execute($sql, $value);
        }
        return false;
    }

    /**
     * Check if the parameters for the delete function are valid
     *
     * @param null $table
     * @param null $value
     * @param null $field
     * @return bool
     */
    private function areDeleteParametersValid(
        $table = null, $value = null, $field = null
    ) {
        return (!empty($table) && !Helper::isEmpty($value) && !empty($field));
    }

    /**
     * Prepared select one statement
     *
     * @param null $table
     * @param null $value
     * @param string $field
     * @return mixed|null
     */
    public function selectOne($table = null, $value = null, $field = 'id') {
        // Check if the parameters are valid
        if ($this->isSelectOneValid($table, $value, $field)) {
            // SQL statement
            $sql = "SELECT *
                    FROM `{$table}`
                    WHERE `{$field}` = ?";
            // Fetch one and return the result
            return $this->fetchOne($sql, $value);
        }
        return null;
    }

    /**
     * Check if the parameters for select one function are valid
     *
     * @param null $table
     * @param null $value
     * @param string $field
     * @return bool
     */
    private function isSelectOneValid(
        $table = null, $value = null, $field = 'id'
    ) {
        return (!empty($table) && !Helper::isEmpty($value) && !empty($field));
    }

    /**
     * Begin a transaction
     */
    public function beginTransaction() {
        if (!is_object($this->pdoObject)) {
            $this->connect();
        }
        $this->pdoObject->beginTransaction();
    }

    /**
     * Commit a transaction
     */
    public function commit() {
        if (!is_object($this->pdoObject)) {
            $this->connect();
        }
        $this->pdoObject->commit();
    }

    /**
     * Roll back a transaction
     */
    public function rollBack() {
        if (!is_object($this->pdoObject)) {
            $this->connect();
        }
        $this->pdoObject->rollBack();
    }

    /**
     * Execute a transaction
     *
     * @param null $sql
     * @param null $params
     * @return bool|null|\PDOStatement
     */
    public function executeTransaction($sql = null, $params = null) {
        // Check if a SQL statement was passed
        if (!empty($sql)) {
            // Execute the query and return the result
            return $this->query($sql, $params);
        }
        return false;
    }

    /**
     * Insert a transaction
     *
     * @param null $table
     * @param null $params
     * @return bool
     */
    public function insertTransaction($table = null, $params = null) {
        // Prepare the insert parameters
        $params = $this->insertArray($params);
        // Check if the table and the parameters are valid
        if (!empty($table) && !empty($params)) {
            // SQL statement
            $sql  = "INSERT INTO `{$table}` (";
            $sql .= implode(", ", $params[0]);
            $sql .= ") VALUES (";
            $sql .= implode(", ", $params[1]);
            $sql .= ")";
            // Execute the transaction and save the result
            $return = $this->executeTransaction($sql, $params[2]);
            // If executing the transaction was successful save the id
            // and return true
            if ($return) {
                $this->id = $this->getLastInsertId();
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Update a transaction
     *
     * @param null $table
     * @param null $params
     * @param null $value
     * @param string $field
     * @return bool|null|\PDOStatement
     */
    public function updateTransaction(
        $table = null, $params = null, $value = null, $field = 'id'
    ) {
        // Prepare the update parameters
        $params = $this->updateArray($params);
        // Check if the update parameters are valid
        if ($this->areUpdateParametersValid($table, $params, $value, $field)) {
            // SQL statement
            $sql  = "UPDATE `{$table}` SET ";
            $sql .= implode(", ", $params[0]);
            $sql .= " WHERE `{$field}` = ?";
            // Assign a new value
            $params[1][] = $value;
            // Execute the transaction and return the result
            return $this->executeTransaction($sql, $params[1]);
        }
        return false;
    }

    /**
     * Delete a transaction
     *
     * @param null $table
     * @param null $value
     * @param string $field
     * @return bool|null|\PDOStatement
     */
    public function deleteTransaction(
        $table = null, $value = null, $field = 'id'
    ) {
        // Check if parameters are valid
        if ($this->areDeleteParametersValid($table, $value, $field)) {
            // SQL statement
            $sql = "DELETE FROM `{$table}`
                    WHERE `{$field}` = ?";
            // Execute the transaction and return the result
            return $this->executeTransaction($sql, $value);
        }
        return false;
    }

    /**
     * Get one transaction
     *
     * @param null $sql
     * @param null $params
     * @return mixed|null
     */
    public function getOneTransaction($sql = null, $params = null) {
        // Check if a SQL statement was passed
        if (!empty($sql)) {
            $statement = $this->query($sql, $params);
            return $statement->fetch($this->fetchMode);
        }
        return null;
    }

    /**
     * Select one transaction
     *
     * @param null $table
     * @param null $value
     * @param string $field
     * @return mixed|null
     */
    public function selectOneTransaction(
        $table = null, $value = null, $field = 'id'
    ) {
        // Check if parameters are valid
        if ($this->isSelectOneValid($table, $value, $field)) {
            // SQL statement
            $sql = "SELECT *
                    FROM `{$table}`
                    WHERE `{$field}` = ?";
            // Execute the SQL statement and return result
            return $this->getOneTransaction($sql, $value);
        }
        return null;
    }
}