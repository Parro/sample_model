<?php

require 'DatabaseException.php';

class Database {
    
    protected $database;
    
    public function __construct() {
        $this->database = new PDO('mysql:host=localhost;dbname=clients', 'username', 
                                  'password');
        $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function saveData($data) {
    
        $sql = "INSERT INTO client 
                    (first_name, last_name, email) 
                VALUES (:first_name, :last_name, :email) 
                ON DUPLICATE KEY UPDATE first_name=:first_name, last_name=:last_name";
        
        $stmt = $this->database->prepare($sql);
        
        $params = array(
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':email' => $data['email'],
        );
        
        return $stmt->execute($params);
    }
}