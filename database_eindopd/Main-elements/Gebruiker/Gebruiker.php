<?php
//database_eindopd/Main-elements/Gebruiker/Gebruiker.php
class Gebruiker {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function selectGebruikerDataByEmail($email) {
        $sql = "SELECT * FROM gebruikers WHERE email = :email";
        $placeholders = [':email' => $email];
        return $this->db->exec($sql, $placeholders)->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateGebruikerDataByEmail($email, $newData) {
        $sql = "UPDATE gebruikers SET naam = :naam, full_name = :full_name WHERE email = :email";
        $placeholders = [
            ':naam' => $newData['naam'],
            ':full_name' => $newData['full_name'],
            ':email' => $email
        ];
        return $this->db->exec($sql, $placeholders);
    }
    public function selectAllGebruikers() {
        $sql = "SELECT * FROM gebruikers";
        return $this->db->exec($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    
}