<?php

require 'DataStoreInterface.php';
require 'DatabaseException.php';

class Database implements DataStoreInterface {
    
    protected $database;
    
    public function __construct(PDO $pdo) {
        $this->database = $pdo;
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function save($location, $kvp) {
        $keys = array_keys($kvp);
        $values = array_values($kvp);
        
        $sql = 'INSERT INTO ' . $location . ' (';
        
        $sql .= implode(',', $keys);
        
        $sql .= ') VALUES (';
        
        foreach($values as $value) {
            $sql .= '?,';
        }
        
        $sql = rtrim($sql, ',');
        
        $sql .= ')';
        
        $stmt = $this->database->prepare($sql);

        try {
            return $stmt->execute($values);
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }
    }
    
    public function update($location, $uniqueKey, $kvp) {
        
        $uk = $kvp[$uniqueKey];
        unset($kvp[$uniqueKey]);
        
        $values = array_values($kvp);
        $values[] = $uk;
        
        $sql = 'UPDATE ' . $table . ' SET ';
        
        foreach($kvp as $k => $v) {
            $sql .= $k . '=?,';
        }
        
        $sql = rtrim($sql, ',');
        
        $sql .= ' WHERE ' . $uniqueKey . '=?';

        $stmt = $this->database->prepare($sql);
        
        try {
            return $stmt->execute($values);
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }        
    }
    
    
    /* These are now part of the interface, but for the example
     * I have prepared, they are not going to be implemented.
     */ 
    public function retrieve($location, array $conditionals = array()) {
        return;
    }
    
    public function delete($location,  array $conditionals = array()) {
        return;
    }
}