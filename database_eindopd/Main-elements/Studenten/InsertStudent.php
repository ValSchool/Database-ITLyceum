<?php
session_start();

require_once 'Student.php'; 
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$student = new Student($myDb);

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addStudent'])) {
        $student_id = $_POST['student_id'];
        $klas_id = $_POST['klas_id'];
        $naam = $_POST['naam'];
        $achternaam = $_POST['achternaam'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $student->insertStuden($student_id, $klas_id, $naam, $achternaam, $email, $password);
        
        header("Location: overzichtStudenten.php");
        exit();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Student Management</h1>

        <!-- Form to add a new student -->
        <form method="post" action="">
            <h2>Add New Student</h2>
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="klas_id">Class ID</label>
                <input type="text" class="form-control" id="klas_id" name="klas_id" required>
            </div>
            <div class="form-group">
                <label for="naam">Naam</label>
                <input type="text" class="form-control" id="naam" name="naam" required>
            </div>
            <div class="form-group">
                <label for="achternaam">Achternaam</label>
                <input type="text" class="form-control" id="achternaam" name="achternaam" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="addStudent">Add Student</button>
        </form>
    </div>
</body>
</html>
