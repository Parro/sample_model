<?php

interface DataStoreInterface {
    
    public function save($location, $kvp);
    
    public function update($location, $uniqueKey, $kvp);
    
    public function retrieve($location, array $conditionals = array());
    
    public function delete($location,  array $conditionals = array());
    
}