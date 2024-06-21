<?php

class Student {
    private $db;

    public function insertStudent($Student_id, $email, $password_hash) {
       
        $hashedPassword = password_hash($password_hash, PASSWORD_DEFAULT);
    
        return $this->db->exec("INSERT INTO studenten (naam, email, password_hash) VALUES (?, ?, ?, ?)", [$naam, $email, $hashedPassword]);
    }

    public function selectStudent() {
        return $this->db->exec("SELECT * from Studenten WHERE Student_id = ?");
    }
    
}