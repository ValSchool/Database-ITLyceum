<?php
// Include database connection and Gesprekken class
require_once '../../Db_connection.php';
require_once '../Gesprekken/Gesprek.php';

// Initialize database connection
$myDb = new DB('itlyceum');
$Gesprekken = new Gesprekken($myDb);

// Handle POST requests for adding, updating, and deleting gesprekken
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addGesprek"])) {
        // Add gesprek
        $student_id = $_POST["student_id"];
        $mentor_id = $_POST["mentor_id"];
        $datum = $_POST["datum"];
        $tijd = $_POST["tijd"];
        $onderwerp = $_POST["onderwerp"];
        $beschrijving = $_POST["beschrijving"];
        
        $result = $Gesprekken->addGesprek($student_id, $mentor_id, $datum, $tijd, $onderwerp, $beschrijving);
        if ($result) {
            echo '<div class="alert alert-success" role="alert">Gesprek toegevoegd.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Fout bij toevoegen gesprek.</div>';
        }
    } elseif (isset($_POST["updateGesprek"])) {
        // Update gesprek
        $gesprek_id = $_POST["gesprek_id"];
        $datum = $_POST["datum"];
        $tijd = $_POST["tijd"];
        $onderwerp = $_POST["onderwerp"];
        $beschrijving = $_POST["beschrijving"];
        
        $result = $Gesprekken->updateGesprek($gesprek_id, $datum, $tijd, $onderwerp, $beschrijving);
        if ($result) {
            echo '<div class="alert alert-success" role="alert">Gesprek bijgewerkt.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Fout bij bijwerken gesprek.</div>';
        }
    } elseif (isset($_POST["deleteGesprek"])) {
        // Delete gesprek
        $gesprek_id = $_POST["gesprek_id"];
        
        $result = $Gesprekken->deleteGesprek($gesprek_id);
        if ($result) {
            echo '<div class="alert alert-success" role="alert">Gesprek verwijderd.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Fout bij verwijderen gesprek.</div>';
        }
    }
}

// Handle GET requests for viewing gesprekken
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["gesprek_id"])) {
        // View gesprek details
        $gesprek_id = $_GET["gesprek_id"];
        
        $gesprek = $Gesprekken->getGesprek($gesprek_id);
        if ($gesprek) {
            // Display gesprek details
            echo "<h2>Gesprek Details</h2>";
            echo "<p><strong>ID:</strong> " . $gesprek['gesprek_id'] . "</p>";
            echo "<p><strong>Datum:</strong> " . $gesprek['datum'] . "</p>";
            echo "<p><strong>Tijd:</strong> " . $gesprek['tijd'] . "</p>";
            echo "<p><strong>Onderwerp:</strong> " . $gesprek['onderwerp'] . "</p>";
            echo "<p><strong>Beschrijving:</strong> " . $gesprek['beschrijving'] . "</p>";
            
            // Provide options for editing or deleting gesprek
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
            echo "<input type='hidden' name='gesprek_id' value='" . $gesprek['gesprek_id'] . "'>";
            echo "<input type='submit' name='updateGesprek' value='Gesprek bijwerken' class='btn btn-primary'>";
            echo "<input type='submit' name='deleteGesprek' value='Gesprek verwijderen' class='btn btn-danger'>";
            echo "</form>";
        } else {
            echo '<div class="alert alert-warning" role="alert">Gesprek niet gevonden.</div>';
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
    <title>Gesprekken Beheren</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        
        <!-- Form to add a new gesprek -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Gesprek Toevoegen</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="student_id">Student ID:</label>
                        <input type="text" class="form-control" id="student_id" name="student_id">
                    </div>
                    <div class="form-group">
                        <label for="mentor_id">Mentor ID:</label>
                        <input type="text" class="form-control" id="mentor_id" name="mentor_id">
                    </div>
                    <div class="form-group">
                        <label for="datum">Datum:</label>
                        <input type="date" class="form-control" id="datum" name="datum">
                    </div>
                    <div class="form-group">
                        <label for="tijd">Tijd:</label>
                        <input type="time" class="form-control" id="tijd" name="tijd">
                    </div>
                    <div class="form-group">
                        <label for="onderwerp">Onderwerp:</label>
                        <input type="text" class="form-control" id="onderwerp" name="onderwerp">
                    </div>
                    <div class="form-group">
                        <label for="beschrijving">Beschrijving:</label>
                        <textarea class="form-control" id="beschrijving" name="beschrijving" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="addGesprek">Gesprek Toevoegen</button>
                </form>
            </div>
        </div>
        
        
    </div>
</body>
</html>
<?php include_once('../../includes/footer.php'); ?>