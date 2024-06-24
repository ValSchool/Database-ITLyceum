<?php
session_start();

require_once 'Student.php';
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$student = new Student($myDb);


if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $student->deleteStudent($student_id);
    header("Location: StudentData.php"); 
    exit();
} else {
    die("No student ID provided.");
}
