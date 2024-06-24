<?php
class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertStudent($student_id, $klas_id, $naam, $achternaam, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO studenten (student_id, klas_id, naam, achternaam, email, password_hash) VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->execute($sql, [$student_id, $klas_id, $naam, $achternaam, $email, $hashedPassword]);
    }

    public function insertStuden($student_id, $klas_id, $naam, $achternaam, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->exec("INSERT INTO studenten (student_id, klas_id, naam, achternaam, email,password_hash) VALUES (?, ?, ?, ?,?,?)", [$student_id, $klas_id, $naam, $achternaam,$email,$password]);
      
    }
    public function getAllStudents() {
        $sql = "SELECT * FROM studenten";
        return $this->db->exec($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertDocent($naam, $email, $password, $klas) {
       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        return $this->db->exec("INSERT INTO gebruikers (naam, email, password, rol, klas) VALUES (?, ?, ?, 'docent',?)", [$naam, $email, $hashedPassword, $klas]);
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
