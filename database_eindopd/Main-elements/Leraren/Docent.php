<?php   
require_once '../../Db_connection.php';

class Docent {
    private $db; // Define the $db property

    public function __construct($db) {
        $this->db = $db;
    }
    public function insertDocent($naam, $email, $password) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Prepare SQL statement
        return $this->db->exec("INSERT INTO gebruikers (naam, email, password, rol) VALUES (?, ?, ?, 'docent')", [$naam, $email, $hashedPassword]);
    }
    

    public function selectDocent() {
        return $this->db->exec("SELECT * from gebruikers WHERE rol = 'docent'");
    }

    public function editDocent($gebruiker_id, $naam = null, $email = null, $password = null) {
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
    
    
    public function deleteDocent($gebruiker_id) {
        return $this->db->exec("DELETE FROM gebruikers WHERE gebruiker_id = ?", [$gebruiker_id]);
    }
    public function koppelDocentAlsMentor($Naam, $klasId) {
        $sql = "UPDATE klassen k 
                JOIN gebruikers g ON k.mentor_id = g.gebruiker_id 
                SET k.mentor_id = g.gebruiker_id
                WHERE g.naam = :naam AND g.rol = 'docent'
                AND k.klas_id = :klas_id";
        
        return $this->db->prepare($sql)->execute([':naam' => $Naam, ':klas_id' => $klasId]);
    }
    
    
}