<?php
session_start();
//dependencies
require_once '../Rooster/Rooster.php';
require_once '../../Db_connection.php';
require_once '../Klassen/Klassen.php';
require_once '../Vakken/Vakken.php'; 

//class definitions
$Rooster = new Rooster($myDb);
$klassen = new Klassen($myDb);
$vakken = new Vakken($myDb);

// Fetch all classes for the dropdown
$allKlassen = $klassen->selectKlassen();

// Initialize variables for rooster data
$selectedKlas = null;
$allRoosters = [];

// Handle form submission for selecting a class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectKlas'])) {
    $klas_id = $_POST['klas_id'];
    $_SESSION['selectedKlas'] = $klas_id; // Store selected class ID in session for use later
    $selectedKlas = $klassen->selectKlas($klas_id); // Implement this method in Klassen class to fetch class details
    if (!$selectedKlas) {
        die("Class not found.");
    }
    
    // Fetch all roosters for the selected class
    $allRoosters = $Rooster->selectRoostersByKlas($klas_id); // Implement this method in Rooster class
}

// Handle form submission for viewing a specific student's roster


?>

<?php include_once('../../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
<div class="container">
    <h1>Rooster Management</h1>

    <!-- Select Class Form -->
    <form method="post" action="">
        <div class="form-group">
            <label for="klas_id">Select Class</label>
            <select class="form-control" id="klas_id" name="klas_id">
                <?php foreach ($allKlassen as $klas) : ?>
                    <option value="<?php echo $klas['klas_id']; ?>"><?php echo htmlspecialchars($klas['naam']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="selectKlas">Select Class</button>
    </form>

    <?php if ($selectedKlas) : ?>
     

        <!-- View Roster for Class -->
        <h3>All Roosters for Class</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rooster ID</th>
                    <th>Weeknummer</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Vak ID</th>
                    <th>Gebruiker ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allRoosters as $rooster) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rooster['rooster_id']); ?></td>
                        <td><?php echo htmlspecialchars($rooster['weeknummer']); ?></td>
                        <td><?php echo htmlspecialchars($rooster['datum']); ?></td>
                        <td><?php echo htmlspecialchars($rooster['tijd']); ?></td>
                        <td><?php echo htmlspecialchars($rooster['vak_id']); ?></td>
                        <td><?php echo htmlspecialchars($rooster['gebruiker_id']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        
    <?php endif; ?>
</div>
</body>
<?php include_once('../../includes/footer.php'); ?>
