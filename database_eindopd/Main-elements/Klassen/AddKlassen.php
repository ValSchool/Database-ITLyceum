<?php
session_start();

require_once 'Klassen.php';
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$klassen = new Klassen($myDb);

// Handle form submission for adding a new class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addKlas'])) {
    $naam = $_POST['naam'];
    $mentor_id = $_POST['mentor_id'];
    $klassen->insertKlas($naam, $mentor_id);
}
?>
<?php include_once('../../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Klas Management</h1>

    <!-- Form to add a new class -->
    <form method="post" action="">
        <h2>Add New Klas</h2>
        <div class="form-group">
            <label for="naam">Klas Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" required>
        </div>
        <div class="form-group">
            <label for="mentor_id">Mentor ID</label>
            <input type="number" class="form-control" id="mentor_id" name="mentor_id" required>
        </div>
        <button type="submit" class="btn btn-primary" name="addKlas">Add Klas</button>
    </form>

    
</div>
</body>
<?php include_once('../../includes/footer.php'); ?>
