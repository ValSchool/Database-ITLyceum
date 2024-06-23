<?php
session_start();

require_once 'Klassen.php';
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$klassen = new Klassen($myDb);

// Handle form submission for adding a new class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addKlas'])) {
    $naam = $_POST['naam'];
    $mentor_id = $_POST['mentor_id'];
    $klassen->insertKlas($naam, $mentor_id);
}

// Handle form submission for editing a class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editKlas'])) {
    $klas_id = $_POST['klas_id'];
    $naam = $_POST['naam'];
    $mentor_id = $_POST['mentor_id'];
    $klassen->editKlas($klas_id, $naam);
}

// Handle form submission for deleting a class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteKlas'])) {
    $klas_id = $_POST['klas_id'];
    $klassen->deleteKlas($klas_id);
}

// Fetch the latest data from the database
$allKlassen = $klassen->selectKlassen();
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
    <h1>Klas Management</h1>

    <!-- Form to add a new class -->
    <form method="post" action="">
        <h2>Add New Klas</h2>
        <div class="form-group">
            <label for="naam">Klas Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" required>
        </div>
        <div class="form-group">
            <label for="mentor_id">Mentor ID</label>
            <input type="number" class="form-control" id="mentor_id" name="mentor_id" required>
        </div>
        <button type="submit" class="btn btn-primary" name="addKlas">Add Klas</button>
    </form>

    <!-- List of current classes -->
    <h2>Current Klassen</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Klas ID</th>
                <th>Klas Naam</th>
                <th>Mentor ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allKlassen as $klas) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($klas['klas_id']); ?></td>
                    <td><?php echo htmlspecialchars($klas['naam']); ?></td>
                    <td><?php echo htmlspecialchars($klas['mentor_id']); ?></td>
                    <td>
                        <!-- Edit and Delete forms -->
                        <a href="EditKlas.php?klas_id=<?php echo $klas['klas_id']; ?>" class="btn btn-warning">Edit</a>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="klas_id" value="<?php echo $klas['klas_id']; ?>">
                            <button type="submit" class="btn btn-danger" name="deleteKlas">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
<?php include_once('../../includes/footer.php'); ?>
