<?php
include '../../Db_connection.php';

class SpecialLogin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    private function getGebruikerByIdentifier($email, $password) {
        $fields = '*';
        $table = 'gebruikers';
        $conditions = 'email = :email';
        $values = [':email' => $email];
        $gebruiker = $this->db->read($fields, $table, $conditions, $values);

        // Check if user exists and password is correct
        if (!empty($gebruiker) && password_verify($password, $gebruiker['password'])) {
            return $gebruiker;
        }

        return null;
    }

    public function loginGebruiker($email, $password) {
        $gebruiker = $this->getGebruikerByIdentifier($email, $password);
        if (!empty($gebruiker)) {
            return $gebruiker;
        }
        return null;
    }
}
