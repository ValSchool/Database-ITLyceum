<?php
// Include database connection and Gesprekken class
require_once '../../Db_connection.php';
require_once '../Gesprekken/Gesprek.php';

// Initialize database connection
$myDb = new DB('itlyceum');
$Gesprekken = new Gesprekken($myDb);

// Function to fetch all students
function getAllStudents($db) {
    $query = "SELECT student_id, naam FROM studenten";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle POST requests for updating and deleting gesprekken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["student_id"])) {
        $student_id = $_POST["student_id"];
        $student_name = $_POST["student_name"]; // To display selected student name
        
        // Fetch gesprekken for the selected student
        $gesprekken = $Gesprekken->getGesprekkenForStudent($student_id);
    }
}
?>

<?php include_once('../../includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesprekken Beheren</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Gesprekken Beheren</h1>
        
        <!-- Form to select a student -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="student_id">Selecteer een student:</label>
                <select class="form-control" id="student_id" name="student_id">
                    <?php
                    // Fetch all students
                    $students = getAllStudents($myDb);
                    foreach ($students as $student) {
                        echo "<option value='" . $student['student_id'] . "'>" . $student['naam'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Gesprekken Tonen</button>
        </form>

        <!-- Display gesprekken for the selected student -->
        <?php if (isset($gesprekken)) : ?>
            <h2>Gesprekken voor <?php echo $student_name; ?></h2>
            <?php if (count($gesprekken) > 0) : ?>
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Datum</th>
                                <th>Tijd</th>
                                <th>Onderwerp</th>
                                <th>Beschrijving</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gesprekken as $gesprek) : ?>
                                <tr>
                                    <td><?php echo $gesprek['gesprek_id']; ?></td>
                                    <td><?php echo $gesprek['datum']; ?></td>
                                    <td><?php echo $gesprek['tijd']; ?></td>
                                    <td><?php echo $gesprek['onderwerp']; ?></td>
                                    <td><?php echo $gesprek['beschrijving']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="alert alert-warning mt-4" role="alert">Geen gesprekken gevonden voor deze student.</div>
            <?php endif; ?>
        <?php endif; ?>
        
    </div>
</body>
</html>

<?php include_once('../../includes/footer.php'); ?>
