<?php

class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertStudent($klas_id, $naam, $achternaam, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->exec("INSERT INTO studenten (klas_id, naam, achternaam, email, password_hash) VALUES (?, ?, ?, ?, ?)", [$klas_id, $naam, $achternaam, $email, $hashedPassword]);
    }
    public function editStudent($student_id, $klas_id = null, $naam = null, $achternaam = null) {
        $fields = [];
        $params = [];
    
        if ($klas_id !== null) {
            $fields[] = "klas_id = ?";
            $params[] = $klas_id;
        }
        if ($naam !== null) {
            $fields[] = "naam = ?";
            $params[] = $naam;
        }
        if ($achternaam !== null) {
            $fields[] = "achternaam = ?";
            $params[] = $achternaam;
        }
        
        // Add student_id to params for WHERE clause
        $params[] = $student_id;
    
        // Construct SQL query
        $sql = "UPDATE studenten SET " . implode(", ", $fields) . " WHERE student_id = ?";
        
        // Execute the query using $this->db->exec or prepare/execute method
        return $this->db->exec($sql, $params);
    }
    
    public function selectStudenten() {
        return $this->db->exec("SELECT * FROM studenten");
    }
    //public function selectStudent($student_id) {
    //    return $this->db->exec("SELECT * FROM studenten WHERE student_id = ?", [$student_id]);
   // }

    public function deleteStudent($student_id) {
        return $this->db->exec("DELETE FROM studenten WHERE student_id = ?", [$student_id]);
    }
}


