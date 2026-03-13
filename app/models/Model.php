<?php
class Model {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getLastId() {
        return $this->db->lastInsertId();
    }
}
