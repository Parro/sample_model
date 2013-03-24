<?php

require 'DatabaseException.php';

class Database {
    
    protected $database;
    
    public function __construct() {
        $this->database = new PDO('mysql:host=localhost;dbname=clients', 'username', 
                                  'password');
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function save($table, $kvp) {
        $keys = array_keys($kvp);
        $values = array_values($kvp);
        
        $sql = 'INSERT INTO ' . $table . ' (';
        
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
    
    public function update($table, $uniqueKey, $kvp) {
        
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
}