<?php
session_start();

require_once 'Student.php';
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$student = new Student($myDb);

// Fetch the student data
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $stmt = $myDb->exec("SELECT * FROM studenten WHERE student_id = ?", [$student_id]);
    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    die("No student ID provided.");
}

// Handle form submission for editing a student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editStudent'])) {
    $student_id = $_POST['student_id'];
    $naam = !empty($_POST['naam']) ? $_POST['naam'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $klas = !empty($_POST['klas']) ? $_POST['klas'] : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $student->editStudent($student_id, $naam, $email, $klas, $password);
    header("Location: StudentData.php"); // Redirect back to the main page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1>Edit Student</h1>
            </div>
            <div class="card-body">
                <!-- Form to edit a student -->
                <form method="post" action="">
                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($studentData['student_id']); ?>">
                    <div class="mb-3">
                        <label for="naam" class="form-label">Naam</label>
                        <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($studentData['naam']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($studentData['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="klas" class="form-label">Klas</label>
                        <input type="text" class="form-control" id="klas" name="klas" value="<?php echo htmlspecialchars($studentData['klas_id']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (leave blank to keep current password)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" name="editStudent">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
