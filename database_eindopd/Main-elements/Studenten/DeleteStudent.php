<?php
session_start();

require_once 'Student.php';  // Include the Student class
require_once '../../Db_connection.php'; // Include the DB class

// Initialize DB connection
$myDb = new DB('itlyceum'); // Adjust the database name ('itlyceum') as per your configuration
$student = new Student($myDb); // Create instance of Student class

// Check if student_id is provided and valid
if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    
    // Call the deleteStudent method to delete the student
    $deleted = $student->deleteStudent($student_id);

    if ($deleted) {
        $_SESSION['success_message'] = "Student deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete student.";
    }
} else {
    $_SESSION['error_message'] = "Student ID not provided.";
}

header('Location: StudentData.php');
exit();

