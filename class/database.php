<?php

class Database {

    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    private function __construct() {
        try {

            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));

            $sql = "CREATE TABLE IF NOT EXISTS `watchList` (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                    words TEXT,
                    fileName VARCHAR(30) NOT NULL,
                    added_date TIMESTAMP
            )";

            // use exec() because no results are returned
            $this->_pdo->query($sql);


        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function query($sql) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
             
            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array()) {
         
            $sql = "{$action} FROM {$table} WHERE {$where[0]}";
            if( !$this->query($sql)->error()) {
                return $this;
            }
   
        return false;
    }

    public function insert($table, $fields = array()) {
        $keys = array_keys($fields);
        $fileName = $fields['fileName'];
        $values = null;
        $x = 1;
        foreach($fields["words"] as $field) {
            
           $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`)  VALUES ('".$field."', '".$fileName."')";
           if(!$this->query($sql, $fields)->error()) {
              return true;
           }
           return false;
        }
    }
 
    public function get($table, $where) {
        return $this->action('SELECT *', $table, $where);
    }

    public function results() {
        return $this->_results;
    } 

    public function count() {
        return $this->_count;
    }

    public function error() {
        return $this->_error;
    }
}