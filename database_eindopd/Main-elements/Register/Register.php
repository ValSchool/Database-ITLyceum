<?php   
require_once '../../Db_connection.php';


class register {
    private $db; // Define the $db property

    public function __construct($db) {
        $this->db = $db;
    }
    public function registerUser($username, $achternaam, $password) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Prepare the SQL statement to insert user data into the database
        $sql = "INSERT INTO studenten (naam, achternaam, password_hash) VALUES (?, ?, ?)";
    
        // Execute the query using the exec method of the DB class
        return $this->db->exec($sql, [$username, $achternaam, $hashedPassword]);
    }
    
    
    
    
    
}


?>
