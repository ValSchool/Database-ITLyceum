<?php
session_start();

require_once '../Rooster/Rooster.php';
require_once '../../Db_connection.php';
require_once '../Klassen/Klassen.php';
require_once '../Vakken/Vakken.php';

$myDb = new DB('itlyceum');
$rooster = new Rooster($myDb);
$klassen = new Klassen($myDb);
$vakken = new Vakken($myDb);

// Fetch all classes for the dropdown
$allKlassen = $klassen->selectKlassen();

// Initialize variables for rooster data
$rooster_id = null;
$selectedRooster = [];

// Fetch the rooster data if rooster_id is provided in GET parameters
if (isset($_GET['rooster_id'])) {
    $rooster_id = $_GET['rooster_id'];
    $selectedRooster = $rooster->selectRoostersByKlas($rooster_id); // Implement this method in Rooster class
    if (!$selectedRooster) {
        die("Rooster entry not found.");
    }
} else {
    die("No rooster ID provided.");
}

// Handle form submission for editing a rooster
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editRooster'])) {
    $rooster_id = $_POST['rooster_id'];
    $klas_id = $_POST['klas_id'];
    $weeknummer = $_POST['weeknummer'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $vak_id = $_POST['vak_id'];
    $gebruiker_id = $_POST['gebruiker_id'];
    $rooster->editRooster($rooster_id, $klas_id, $weeknummer, $datum, $tijd, $vak_id, $gebruiker_id);
    header("Location: EditRooster.php?rooster_id=$rooster_id"); // Redirect back to edit page to reflect changes
    exit();
}

?>

<?php include_once('../../includes/header.php'); ?>

<div class="container">
    <h1>Edit Rooster</h1>

    <!-- Form to edit a rooster -->
    <form method="post" action="">
        <input type="hidden" name="rooster_id" value="<?php echo htmlspecialchars($selectedRooster['rooster_id']); ?>">
        <div class="form-group">
            <label for="klas_id">Klas ID</label>
            <input type="text" class="form-control" id="klas_id" name="klas_id" value="<?php echo htmlspecialchars($selectedRooster['klas_id']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="weeknummer">Weeknummer</label>
            <input type="number" class="form-control" id="weeknummer" name="weeknummer" value="<?php echo htmlspecialchars($selectedRooster['weeknummer']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="datum">Datum</label>
            <input type="date" class="form-control" id="datum" name="datum" value="<?php echo htmlspecialchars($selectedRooster['datum']); ?>">
        </div>
        <div class="form-group">
            <label for="tijd">Tijd</label>
            <input type="time" class="form-control" id="tijd" name="tijd" value="<?php echo htmlspecialchars($selectedRooster['tijd']); ?>">
        </div>
        <div class="form-group">
            <label for="vak_id">Vak ID</label>
            <input type="number" class="form-control" id="vak_id" name="vak_id" value="<?php echo htmlspecialchars($selectedRooster['vak_id']); ?>">
        </div>
        <div class="form-group">
            <label for="gebruiker_id">Gebruiker ID</label>
            <input type="number" class="form-control" id="gebruiker_id" name="gebruiker_id" value="<?php echo htmlspecialchars($selectedRooster['gebruiker_id']); ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="editRooster">Save changes</button>
    </form>
</div>

<?php include_once('../../includes/footer.php'); ?>
