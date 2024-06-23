<?php
require_once '../../Db_connection.php';
class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertStudent($student_id, $klas_id, $naam, $achternaam, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->exec("INSERT INTO studenten (student_id, klas_id, naam, achternaam, email, password) VALUES (?, ?, ?, ?, ?, ?)", [$student_id, $klas_id, $naam, $achternaam, $email, $hashedPassword]);
    }

    public function selectStudent($student_id) {
        return $this->db->exec("SELECT * FROM studenten WHERE student_id = ?", [$student_id]);
    }
    public function getAllClasses() {
        return $this->db->query("SELECT * FROM klassen");
    }

    public function editStudent($student_id, $naam = null, $email = null, $password = null) {
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
            $fields[] = "password_hash = ?";
            $params[] = $hashedPassword;
        }

        $params[] = $student_id;
        $sql = "UPDATE studenten SET " . implode(", ", $fields) . " WHERE student_id = ?";
        return $this->db->exec($sql, $params);
    }
    
    public function selectStudenten() {
        return $this->db->exec("SELECT * FROM studenten");
    }

    public function deleteStudent($student_id) {
        return $this->db->exec("DELETE FROM studenten WHERE student_id = ?", [$student_id]);
    }
}

?>
