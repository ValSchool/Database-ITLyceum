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

    public function editStudent($Student_id, = null, $klas_id = null, $naam = null, $email = null, $password = null) {
        $fields = [];
        $params = [];
    
        if ($naam !== null) {
            $fields[] = "naam = ?";
            $params[] = $naam;
        }
    
        if ($email !== null) {
            $fields[] = "email = ?";
            $params[] = $email;
        }
    
        if ($password !== null) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $fields[] = "password = ?";
            $params[] = $hashedPassword;
        }
    
        $params[] = $gebruiker_id;
        $sql = "UPDATE gebruikers SET " . implode(", ", $fields) . " WHERE gebruiker_id = ?";
        return $this->db->exec($sql, $params);
    }
    
    public function selectStudenten() {
        return $this->db->exec("SELECT * from Studenten");
    }
    public function deleteStudent($student_id) {
        return $this->db->exec("DELETE FROM gebruikers WHERE gebruiker_id = ?", [$student_id]);
    }
}