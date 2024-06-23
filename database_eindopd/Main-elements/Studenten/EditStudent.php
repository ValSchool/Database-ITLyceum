<?php
session_start();

require_once 'Student.php'; // Ensure the path is correct
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$Student = new Student($myDb);

// Initialize $studentData
$studentData = [];

// Fetch the student data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $stmt = $myDb->exec("SELECT * FROM studenten WHERE student_id = ?", [$student_id]);
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    // If form is submitted via POST, populate $studentData from POST
    $student_id = $_POST['student_id'];
    $studentData['naam'] = $_POST['naam'];
    $studentData['achternaam'] = $_POST['achternaam'];
    $studentData['klas_id'] = $_POST['klas_id'];
} else {
    die("No Student ID provided or invalid request.");
}

// Handle form submission for editing a student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editStudent'])) {
    $student_id = $_POST['student_id'];
    $naam = !empty($_POST['naam']) ? $_POST['naam'] : null;
    $achternaam = !empty($_POST['achternaam']) ? $_POST['achternaam'] : null;
    $klas_id = !empty($_POST['klas_id']) ? $_POST['klas_id'] : null;
    $Student->editStudent($student_id, $klas_id, $naam, $achternaam);
    header("Location: StudentData.php"); // Redirect back to the main page
    exit();
}

?>

<?php include_once('../../includes/header.php'); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Edit Student</h1>

    <!-- Form to edit a student -->
    <form method="post" action="">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($studentData['student_id']); ?>">
        <div class="form-group">
            <label for="naam">Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($studentData['naam']); ?>">
        </div>
        <div class="form-group">
            <label for="achternaam">Achternaam</label>
            <input type="text" class="form-control" id="achternaam" name="achternaam" value="<?php echo htmlspecialchars($studentData['achternaam']); ?>">
        </div>
        <div class="form-group">
            <label for="klas_id">Klas ID</label>
            <input type="text" class="form-control" id="klas_id" name="klas_id" value="<?php echo htmlspecialchars($studentData['klas_id']); ?>">
        </div>
     
        <button type="submit" class="btn btn-primary" name="editStudent">Save changes</button>
    </form>
</div>
</body>
<?php include_once('../../includes/footer.php'); ?>
