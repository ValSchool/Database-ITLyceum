<?php
require_once '../../Db_connection.php';

class Vakken {
    private $db; // Define the $db property

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertVak($naam, $docent_id) {
        // Prepare SQL statement
        return $this->db->exec("INSERT INTO vakken (naam, docent_id) VALUES (?, ?)", [$naam, $docent_id]);
    }

    public function selectVakken() {
        return $this->db->exec("SELECT * FROM vakken")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function selectVakById($vak_id) {
        return $this->db->exec("SELECT * FROM vakken WHERE vak_id = ?")->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function editVak($vak_id, $naam, $docent_id) {
        return $this->db->exec("UPDATE vakken SET naam = ?, docent_id = ? WHERE vak_id = ?", [$naam, $docent_id, $vak_id]);
    }

    public function deleteVak($vak_id) {
        return $this->db->exec("DELETE FROM vakken WHERE vak_id = ?", [$vak_id]);
    }
}
