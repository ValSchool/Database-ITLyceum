<?php
session_start();

require_once '../Rooster/Rooster.php'; // Assuming Rooster class is defined here
require_once '../../Db_connection.php'; // Adjust path as per your directory structure
require_once '../Klassen/Klassen.php'; // Assuming Klassen class is defined here
require_once '../Vakken/Vakken.php'; // Assuming Vakken class is defined here

// Initialize database connection
try {
    // Adjust these parameters with your actual database credentials
    $db = new PDO('mysql:host=localhost;dbname=your_dbname', 'your_username', 'your_password');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

$rooster = new Rooster($db);
$klassen = new Klassen($db);
$vakken = new Vakken($db);

// Fetch all classes for the dropdown
$allKlassen = $klassen->selectKlassen();

// Initialize variables for rooster data
$selectedKlas = null;
$allRoosters = [];

// Handle form submission for selecting a class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectKlas'])) {
    $klas_id = $_POST['klas_id'];
    $_SESSION['selectedKlas'] = $klas_id; // Store selected class ID in session for use later
    $selectedKlas = $klassen->selectKlasById($klas_id); // Implement this method in Klassen class to fetch class details
    if (!$selectedKlas) {
        die("Class not found.");
    }
    
    // Fetch all roosters for the selected class
    $allRoosters = $rooster->selectRoostersByKlas($klas_id); // Implement this method in Rooster class
}

// Handle form submission for viewing a specific student's roster
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectStudent'])) {
    $gebruiker_id = $_POST['gebruiker_id'];
    $allRoosters = $rooster->selectRoostersByStudent($gebruiker_id); // Implement this method in Rooster class
}

?>

<?php include_once('../../includes/header.php'); ?>

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
        <h2>Class: <?php echo htmlspecialchars($selectedKlas['naam']); ?></h2>

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

        <!-- Select Student Form -->
        <form method="post" action="">
            <div class="form-group">
                <label for="gebruiker_id">Select Student (Gebruiker ID)</label>
                <input type="number" class="form-control" id="gebruiker_id" name="gebruiker_id" required>
            </div>
            <button type="submit" class="btn btn-primary" name="selectStudent">View Student's Rooster</button>
        </form>
    <?php endif; ?>
</div>

<?php include_once('../../includes/footer.php'); ?>
