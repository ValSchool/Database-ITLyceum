<?php
require_once '../../Db_connection.php';

class Klassen {
    private $db; // Define the $db property

    public function __construct($db) {
        $this->db = $db;
    }

    public function insertKlas($naam, $mentor_id) {
        // Prepare SQL statement
        return $this->db->exec("INSERT INTO klassen (naam, mentor_id) VALUES (?, ?)", [$naam, $mentor_id]);
    }

    public function selectKlassen() {
        return $this->db->exec("SELECT * FROM klassen")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editKlas($klas_id, $naam, $mentor_id) {
        return $this->db->exec("UPDATE klassen SET naam = ?, mentor_id = ? WHERE klas_id = ?", [$naam, $mentor_id, $klas_id]);
    }

    public function deleteKlas($klas_id) {
        return $this->db->exec("DELETE FROM klassen WHERE klas_id = ?", [$klas_id]);
    }
}
?>
