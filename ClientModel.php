<?php

require 'ClientDataStore.php';
require 'ClientValidation.php';

class ClientModel
{
    public $database;
    public $validator;
    public $data = array();
 
    public function __construct(array $data = array()) {
        $this->database = new ClientDataStore();
        $this->validator = new ClientValidation();
        $this->data = $data;
    }
    
    public function store(array $data = array()) {
        if(empty($data)) {
            $data = $this->data; // Fallback
        }
        
        $vd = $this->validator->validateData($data);
        return $this->database->saveClient($vd);
    }
}