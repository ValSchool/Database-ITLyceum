<?php

class Student {
    private $db;

    public function insertStudent($student_id, $klas_id, $naam, $achternaam, $email, $password_hash) {
       
        $hashedPassword = password_hash($password_hash, PASSWORD_DEFAULT);
    
        return $this->db->exec("INSERT INTO studenten (student_id, klas_id, naam, achternaam, email, password_hash) VALUES (?, ?, ?, ?, ?, ?)", [$student_id, $klas_id, $naam, $achternaam, $email, $password_hash]);
    }

    public function selectStudent() {
        return $this->db->exec("SELECT * from Studenten WHERE student_id = ?");
    }
    
}