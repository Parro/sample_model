<?php

require 'ValidatorInterface.php';
require 'InvalidDataException.php';

class ClientValidation implements ValidatorInterface {
    
    // All validated data items are required
    public $validated_data = array(
        'first_name' => '',
        'last_name' => '',
        'email' => '',
    );
    
    protected $data_has_been_validated = false;
    
    
    public function validate(array $data = array()) {
        
        $this->data = $data;
        
        if(!isset($data['first_name']) || 
           !isset($data['last_name']) ||
           !isset($data['email'])) {
            throw new InvalidDataException('Required data missing');
        }
        
        if(empty($data['first_name']) || 
           empty($data['last_name']) ||
           empty($data['email'])) {
            throw new InvalidDataException('Required data empty');
        }
        
        $this->validated_data['first_name'] = filter_var($data['first_name'], FILTER_SANITIZE_STRING);
        $this->validated_data['last_name'] = filter_var($data['last_name'], FILTER_SANITIZE_STRING);
        
        if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {        
            $this->validated_data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        } else {
            throw new InvalidDataException('Email address invalid');
        }
        
        $this->data_has_been_validated = true;
        return $this->validated_data;
    }
    
}