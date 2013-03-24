<?php

require 'ClientDataStore.php';
require 'ClientValidation.php';

class ClientModel
{
    public $database;
    public $validator;
    public $data = array();
 
    public function __construct(ClientDataStore $datastore, ValidatorInterface $validator, array $data = array()) {
        $this->database = $datastore;
        $this->validator = $validator;
        $this->data = $data;
    }
    
    public function store(array $data = array()) {
        if(empty($data)) {
            $data = $this->data; // Fallback
        }
        
        $vd = $this->validator->validate($data);
        return $this->database->saveClient($vd);
    }
}