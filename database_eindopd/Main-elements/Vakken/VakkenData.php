<?php
session_start();

require_once 'Vakken.php'; // Ensure the path is correct
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$vakken = new Vakken($myDb);

// Handle form submission for adding a new vak
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addVak'])) {
    $naam = $_POST['naam'];
    $gebruiker_id = $_POST['gebruiker_id'];
    $vakken->insertVak($naam, $gebruiker_id);
}

// Handle form submission for deleting a vak
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteVak'])) {
    $vak_id = $_POST['vak_id'];
    $vakken->deleteVak($vak_id);
}

// Fetch the latest data from the database
$allVakken = $vakken->selectVakken();
?>

<?php include_once('../../includes/header.php'); ?>

<div class="container">
    <h1>Vak Management</h1>

    <!-- Form to add a new vak -->
    <form method="post" action="">
        <h2>Add New Vak</h2>
        <div class="form-group">
            <label for="naam">Vak Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" required>
        </div>
        <div class="form-group">
            <label for="gebruiker_id">Gebruiker ID</label>
            <input type="text" class="form-control" id="gebruiker_id" name="gebruiker_id" required>
        </div>
    
        <button type="submit" class="btn btn-primary" name="addVak">Add Vak</button>
    </form>

    <!-- List of current vakken -->
    <h2>Current Vakken</h2>
    <div style="max-height: 500px; overflow-y: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Vak ID</th>
                    <th>Vak Naam</th>
                    <th>Gebruiker ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allVakken as $vak) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vak['vak_id']); ?></td>
                        <td><?php echo htmlspecialchars($vak['naam']); ?></td>
                        <td><?php echo htmlspecialchars($vak['gebruiker_id']); ?></td>
                        <td>
                            <!-- Edit link -->
                            <a href="editvak.php?vak_id=<?php echo $vak['vak_id']; ?>" class="btn btn-warning">Edit</a>
                            <!-- Delete form -->
                            <form method="post" action="">
                                <input type="hidden" name="vak_id" value="<?php echo $vak['vak_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="deleteVak">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once('../../includes/footer.php'); ?>
