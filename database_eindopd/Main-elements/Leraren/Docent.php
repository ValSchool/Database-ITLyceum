<?php   
require_once '../../Db_connection.php';

class Docent {
    private $db; // Define the $db property

    public function __construct($db) {
        $this->db = $db;
    }
    public function insertDocent($naam, $email, $password, $klas) {
       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        return $this->db->exec("INSERT INTO gebruikers (naam, email, password, rol, klas) VALUES (?, ?, ?, 'docent',?)", [$naam, $email, $hashedPassword, $klas]);
    }
    

    public function selectDocent() {
        return $this->db->exec("SELECT * from gebruikers WHERE rol = 'docent'");
    }

    public function editDocent($gebruiker_id, $naam = null, $email = null, $klas = null, $password = null) {
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

        if ($klas !== null) {
            $fields[] = "klas = ?";
            $params[] = $klas;
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
    
    
    public function deleteDocent($gebruiker_id) {
        return $this->db->exec("DELETE FROM gebruikers WHERE gebruiker_id = ?", [$gebruiker_id]);
    }
    
}