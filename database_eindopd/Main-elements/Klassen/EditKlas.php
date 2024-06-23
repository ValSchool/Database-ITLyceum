<?php
session_start();

require_once '../../Db_connection.php';
require_once 'Klassen.php';

$myDb = new DB('itlyceum');
$klassen = new Klassen($myDb);

// Ensure klas_id is provided in the URL
if (isset($_GET['klas_id'])) {
    $klas_id = $_GET['klas_id'];
    
    // Fetch class data based on klas_id
    $klas = $klassen->selectKlas($klas_id);
    
    if (!$klas) {
        // Handle case where klas_id is not found
        die('Klas not found.');
    }
} else {
    // Handle case where klas_id is not provided in the URL
    die('Klas ID not specified.');
}

// Handle form submission for updating class details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editKlas'])) {
    $naam = $_POST['naam'];
    $klassen->editKlas($klas_id, $naam);
    // Redirect back to Klassen.php after editing
    header('Location: KlassenData.php');
    exit();
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
    <h1>Edit Klas</h1>
    
    <!-- Form to edit class details -->
    <form method="post" action="">
        <div class="form-group">
            <label for="naam">Klas Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" value="<?php echo isset($klas['naam']) ? htmlspecialchars($klas['naam']) : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="editKlas">Update Klas</button>
    </form>
</div>
</body>
<?php include_once('../../includes/footer.php'); ?>
