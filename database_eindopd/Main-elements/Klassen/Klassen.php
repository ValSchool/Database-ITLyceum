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
    public function selectKlas($klas_id)
    {
        return $this->db->exec("SELECT * FROM klassen WHERE klas_id = klas_id")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function selectStudentenInKlas($klas_id)
    {
        return $this->db->exec("SELECT * FROM studenten WHERE klas_id = ?", [$klas_id])->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function editKlas($klas_id, $naam, ) {
        return $this->db->exec("UPDATE klassen SET naam = ? WHERE klas_id = ?", [$naam,  $klas_id]);
    }

    public function deleteKlas($klas_id) {
        return $this->db->exec("DELETE FROM klassen WHERE klas_id = ?", [$klas_id]);
    }public function klasHeeftMentor($klasId) {
        $sql = "SELECT mentor_id FROM klassen WHERE klas_id = $klasId";
        $result = $this->db->exec($sql);
        
        if ($result === false) {
            // Handle error if exec() fails
            return false;
        }
        
        // Fetch the result manually
        $row = $result->fetch(PDO::FETCH_ASSOC);
        
        // Check if mentor_id exists
        return !empty($row['mentor_id']);
    }
    
    
}

