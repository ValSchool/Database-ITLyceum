<?php
require_once '../../Db_connection.php';

class Vakken {
    private $db; // Define the $db property

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertVak($naam, $gebruiker_id) {
        // Prepare SQL statement
        return $this->db->exec("INSERT INTO vakken (naam, gebruiker_id) VALUES (?, ?)", [$naam, $gebruiker_id]);
    }

    public function selectVakken() {
        return $this->db->exec("SELECT * FROM vakken")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function selectVakById($vak_id) {
        $sql = "SELECT * FROM vakken WHERE vak_id = '{$vak_id}'";
        $stmt = $this->db->exec($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
     

    public function editVak($vak_id, $naam, $gebruiker_id) {
        // Validate gebruiker_id
        if (empty($gebruiker_id)) {
            throw new Exception('Gebruiker ID cannot be empty.');
        }
    
        return $this->db->exec("UPDATE vakken SET naam = ?, gebruiker_id = ? WHERE vak_id = ?", [$naam, $gebruiker_id, $vak_id]);
    }
    
    
 

 public function deleteVak($vak_id) {
    // Delete from roosters first
    $this->db->exec("DELETE FROM roosters WHERE vak_id = ?", [$vak_id]);

    // Then delete from vakken
    return $this->db->exec("DELETE FROM vakken WHERE vak_id = ?", [$vak_id]);
}
}
