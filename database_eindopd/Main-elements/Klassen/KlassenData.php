<?php
session_start();

require_once 'Klassen.php';
require_once '../Leraren/Docent.php';
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$klassen = new Klassen($myDb);

// Fetch all classes
$allKlassen = $klassen->selectKlassen();

// Initialize variables for selected class and students
$selected_klas = null;
$students_in_klas = [];

// Handle form submission for selecting a class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['selectKlas'])) {
        $klas_id = $_POST['klas_id'];
        $selected_klas = $klassen->selectKlas($klas_id);
        if (!$selected_klas) {
            die("Class not found.");
        }
        
        // Fetch students in the selected class
        $students_in_klas = $klassen->selectStudentenInKlas($klas_id);
    }
    
    // Handle form submission for koppelMentor button
    if (isset($_POST['koppelMentor'])) {
        $klas_id = $_POST['klas_id'];
        $docentNaam = 'Your Docent Name'; // Replace with actual docent name from form or session
        $result = $Docent->koppelDocentAlsMentor($docentNaam, $klas_id);
        // Handle result as needed
        if ($result) {
            // Success message or redirect
            header("Location: your_success_page.php");
            exit;
        } else {
            // Error handling
            echo "Failed to link docent as mentor.";
        }
    }
}
?>

<?php include_once('../../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klas Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Klas Management</h1>

    <!-- List of all classes -->
    <h2>All Klassen</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Klas ID</th>
                <th>Klas Naam</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allKlassen as $klas) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($klas['klas_id']); ?></td>
                    <td><?php echo htmlspecialchars($klas['naam']); ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="klas_id" value="<?php echo $klas['klas_id']; ?>">
                            <button type="submit" class="btn btn-primary" name="selectKlas">Select</button>
                            
                            <!-- Check if class has no mentor to show the button -->
                            <?php if (!$klassen->klasHeeftMentor($klas['klas_id'])) : ?>
                                <button type="submit" class="btn btn-success ml-2" name="koppelMentor">Koppel Docent Als Mentor</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Display selected class and students -->
    <?php if ($selected_klas) : ?>
        <hr>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Naam</th>
                    <th>Achternaam</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students_in_klas as $student) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['naam']); ?></td>
                        <td><?php echo htmlspecialchars($student['achternaam']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
<?php include_once('../../includes/footer.php'); ?>
