<?php
session_start();

require_once 'Docent.php'; // Ensure the path is correct
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$docent = new Docent($myDb);

// Fetch the docent data
if (isset($_GET['gebruiker_id'])) {
    $gebruiker_id = $_GET['gebruiker_id'];
    $stmt = $myDb->exec("SELECT * FROM gebruikers WHERE gebruiker_id = ?", [$gebruiker_id]);
    $docentData = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    die("No docent ID provided.");
}

// Handle form submission for editing a docent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editDocent'])) {
    $gebruiker_id = $_POST['gebruiker_id'];
    $naam = !empty($_POST['naam']) ? $_POST['naam'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $klas = !empty($_POST['klas']) ? $_POST['klas'] : null;
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $docent->editDocent($gebruiker_id, $naam, $email, $klas, $password);
    header("Location: DocentData.php"); // Redirect back to the main page
    exit();
}

?>

<?php include_once('../../includes/header.php'); ?>

<div class="container">
    <h1>Edit Docent</h1>

    <!-- Form to edit a docent -->
    <form method="post" action="">
        <input type="hidden" name="gebruiker_id" value="<?php echo htmlspecialchars($docentData['gebruiker_id']); ?>">
        <div class="form-group">
            <label for="naam">Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($docentData['naam']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($docentData['email']); ?>">
        </div>
        <div class="form-group">
            <label for="klas">Klas</label>
            <input type="text" class="form-control" id="klas" name="klas" value="<?php echo htmlspecialchars($docentData['klas']); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="editDocent">Save changes</button>
    </form>
</div>

<?php include_once('../../includes/footer.php'); ?>