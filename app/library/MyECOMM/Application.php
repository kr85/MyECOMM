<?php namespace MyECOMM;

use MyECOMM\Database\Extension\MySQL;

/**
 * Class Application
 */
abstract class Application {

    /**
     * @var MySQL instance
     */
    protected $Db;

    /**
     * @var Database table name
     */
    protected $table;

    /**
     * @var Record id
     */
    public $id;

    /**
     * Constructor
     */
    public function __construct() {
        $this->Db = new MySQL();
    }

    /**
     * Fetch one record
     *
     * @param null $id
     * @param string $field
     * @return mixed|null
     */
    public function getOne($id = null, $field = 'id') {
        return $this->Db->selectOne($this->table, $id, $field);
    }

    /**
     * Insert a record
     *
     * @param null $params
     * @return bool
     */
    public function insert($params = null) {

        if ($this->Db->insert($this->table, $params)) {

            $this->id = $this->Db->id;
            return true;

        }

        return false;
    }

    /**
     * Update a record
     *
     * @param null $params
     * @param null $id
     * @return bool|mixed
     */
    public function update($params = null, $id = null) {
        return $this->Db->update($this->table, $params, $id);
    }

    /**
     * Delete a record
     *
     * @param null $id
     * @return bool|mixed
     */
    public function delete($id = null) {
        return $this->Db->delete($this->table, $id);
    }
}