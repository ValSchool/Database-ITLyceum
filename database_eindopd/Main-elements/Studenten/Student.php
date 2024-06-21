<?php

class Student {
    private $db;

    public function insertDocent($naam, $email, $password) {
       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        return $this->db->exec("INSERT INTO studenten (naam, email, password_hash) VALUES (?, ?, ?, ?)", [$naam, $email, $hashedPassword]);
    }
    
}