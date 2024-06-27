<?php
class Rooster {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    private function getNextWeekNumber() {
        $today = new DateTime();
        $today->modify('+1 week');
        return (int)$today->format('W');
    }

    public function insertRoosterForNextWeek($klas_id, $datum, $tijd, $vak_id, $gebruiker_id) {
        $weeknummer = $this->getNextWeekNumber();
        $sql = "INSERT INTO roosters (klas_id, weeknummer, datum, tijd, vak_id, gebruiker_id) 
                VALUES (:klas_id, :weeknummer, :datum, :tijd, :vak_id, :gebruiker_id)";
        $stmt = $this->db->exec($sql, [
            ':klas_id' => $klas_id,
            ':weeknummer' => $weeknummer,
            ':datum' => $datum,
            ':tijd' => $tijd,
            ':vak_id' => $vak_id,
            ':gebruiker_id' => $gebruiker_id
        ]);
        return $stmt; // Assuming exec method returns a statement object
    }
    

    public function selectRoostersByKlas($klas_id) {
        return $this->db->exec("SELECT * FROM roosters WHERE klas_id = :klas_id", [':klas_id' => $klas_id]);
    }
    
    

    public function selectRoostersByKlasAndWeek($klas_id, $weeknummer) {

        return $this->db->exec("SELECT * FROM roosters WHERE klas_id = '$klas_id' AND weeknummer = '$weeknummer'");
    }
    
    public function editRooster($rooster_id, $klas_id, $weeknummer, $datum, $tijd, $vak_id, $gebruiker_id) {
        $sql = "UPDATE roosters 
                SET klas_id = :klas_id, weeknummer = :weeknummer, datum = :datum, tijd = :tijd, vak_id = :vak_id, gebruiker_id = :gebruiker_id 
                WHERE rooster_id = :rooster_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':rooster_id' => $rooster_id,
            ':klas_id' => $klas_id,
            ':weeknummer' => $weeknummer,
            ':datum' => $datum,
            ':tijd' => $tijd,
            ':vak_id' => $vak_id,
            ':gebruiker_id' => $gebruiker_id
        ]);
    }

    public function deleteRooster($rooster_id) {
        $sql = "DELETE FROM roosters WHERE rooster_id = :rooster_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':rooster_id' => $rooster_id]);
    }
}
