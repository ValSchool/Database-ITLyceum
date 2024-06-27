<?php
//database_eindopd/Main-elements/Login/login.php
include '../../Db_connection.php';
    class Login {
        private $db;
    
        public function __construct($db) {
            $this->db = $db;
        }
    
        private function getStudentByIdentifier($email, $password_hash) {
            // variables
            $fields = '*';
            $table = 'studenten';
            $conditions = 'email = :email';
            $values = [':email' => $email];
            $student = $this->db->read($fields, $table, $conditions, $values);
        
            // Check if user exists and password is correct
            if (!empty($student) && password_verify($password_hash, $student['password_hash'])) {
                // Password is correct, return user data
                return $student;
            }
        
            // User not found or incorrect password
            return null;
        }
        
        public function loginStudent($email, $password_hash) {
            // Fetch user from database based on username
            $student = $this->getStudentByIdentifier($email, $password_hash);
        
            // Check if user exists0    
            if (!empty($student)) {
                // User found, return user data
                return $student;
            }
        
            // User not found or incorrect password
            return null;
        }
    }
    
