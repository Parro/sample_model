<?php

require 'Database.php';

class ClientDataStore {
    
    protected $database;
    
    public function __construct() {
        $this->database = new Database();
    }
    
    public function saveClient($data) {
        try {
            return $this->database->save('client', $data);
        } catch (DatabaseException $e) {
            return $this->database->update('client', 'email', $data);
        }
    }
    
}