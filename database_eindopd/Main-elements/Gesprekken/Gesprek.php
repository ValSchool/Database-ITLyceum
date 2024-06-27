<?php

class Gesprekken {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Methods for CRUD operations

    public function addGesprek($student_id, $mentor_id, $datum, $tijd, $onderwerp, $beschrijving) {
        return $this->db->exec(
            "INSERT INTO gesprekken (student_id, mentor_id, datum, tijd, onderwerp, beschrijving) VALUES (?, ?, ?, ?, ?, ?)",
            [$student_id, $mentor_id, $datum, $tijd, $onderwerp, $beschrijving]
        );
    }

    public function getGesprek($gesprek_id) {
        return $this->db->exec(
            "SELECT * FROM gesprekken WHERE gesprek_id = ?",
            [$gesprek_id]
        );
    }

    public function updateGesprek($gesprek_id, $datum, $tijd, $onderwerp, $beschrijving) {
        return $this->db->exec(
            "UPDATE gesprekken SET datum = ?, tijd = ?, onderwerp = ?, beschrijving = ? WHERE gesprek_id = ?",
            [$datum, $tijd, $onderwerp, $beschrijving, $gesprek_id]
        );
    }

    public function deleteGesprek($gesprek_id) {
        return $this->db->exec(
            "DELETE FROM gesprekken WHERE gesprek_id = ?",
            [$gesprek_id]
        );
    }

    public function getGesprekkenForStudent($student_id) {
        return $this->db->exec(
            "SELECT * FROM gesprekken WHERE student_id = ?",
            [$student_id]
        );
    }
    public function getGesprekkenForMentor($mentor_id) {
        return $this->db->exec(
            "SELECT * FROM gesprekken WHERE mentor_id = ?",
            [$mentor_id]
        );
    }
    
}
