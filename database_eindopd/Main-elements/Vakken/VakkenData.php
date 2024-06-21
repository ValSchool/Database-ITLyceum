<?php
session_start();

require_once 'Vakken.php'; // Ensure the path is correct
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$vakken = new Vakken($myDb);

// Handle form submission for adding a new vak
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addVak'])) {
    $naam = $_POST['naam'];
    $docent_id = $_POST['docent_id'];
    $vakken->insertVak($naam, $docent_id);
}

// Handle form submission for editing a vak
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editVak'])) {
    $vak_id = $_POST['vak_id'];
    $naam = $_POST['naam'];
    $docent_id = $_POST['docent_id'];
    $vakken->editVak($vak_id, $naam, $docent_id);
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
            <label for="docent_id">Docent ID</label>
            <input type="number" class="form-control" id="docent_id" name="docent_id" required>
        </div>
        <button type="submit" class="btn btn-primary" name="addVak">Add Vak</button>
    </form>

    <!-- List of current vakken -->
    <h2>Current Vakken</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Vak ID</th>
                <th>Vak Naam</th>
                <th>Docent ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allVakken as $vak) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($vak['vak_id']); ?></td>
                    <td><?php echo htmlspecialchars($vak['naam']); ?></td>
                    <td><?php echo htmlspecialchars($vak['docent_id']); ?></td>
                    <td>
                        <!-- Edit and Delete forms -->
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="vak_id" value="<?php echo $vak['vak_id']; ?>">
                            <input type="hidden" name="naam" value="<?php echo $vak['naam']; ?>">
                            <input type="hidden" name="docent_id" value="<?php echo $vak['docent_id']; ?>">
                            <button type="submit" class="btn btn-warning" name="editVak">Edit</button>
                        </form>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="vak_id" value="<?php echo $vak['vak_id']; ?>">
                            <button type="submit" class="btn btn-danger" name="deleteVak">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once('../../includes/footer.php'); ?>
