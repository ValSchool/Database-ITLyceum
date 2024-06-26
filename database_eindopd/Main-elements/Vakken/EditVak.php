
<?php
session_start();

require_once 'Vakken.php'; // Ensure the path is correct
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$vakken = new Vakken($myDb);

// Initialize variables to hold vak details
$vak_id = $_GET['vak_id'] ?? null;
$vak_details = [];

// Fetch vak details based on vak_id
if ($vak_id) {
    $vak_details = $vakken->selectVakById($vak_id);
}

// Handle form submission for updating vak details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateVak'])) {
    $naam = $_POST['naam'];
    $gebruiker_id = $_POST['gebruiker_id'];

    try {
        // Ensure gebruiker_id is not empty
        if (empty($gebruiker_id)) {
            throw new Exception('Gebruiker ID cannot be empty.');
        }

        // Perform the edit operation
        $vakken->editVak($vak_id, $naam, $gebruiker_id);

        // Redirect to index.php after successful edit
        header("Location: vakkenData.php");
        exit();
    } catch (Exception $e) {
        if ($e->getMessage() === 'Gebruiker ID cannot be empty.') {
            $error_message = 'Gebruiker ID doesn\'t exist.';
        } else {
            $error_message = 'Error: ' . $e->getMessage();
        }
    }
    
}

?>

<?php include_once('../../includes/header.php'); ?>

<div class="container">
    <h1>Edit Vak</h1>

    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="editGesprek.php?gesprek_id=<?= htmlspecialchars($gesprek_id) ?>">
        <div class="form-group">
            <label for="Datum">Datum</label>
            <input type="text" class="form-control" id="naam" name="na  am" value="<?php echo htmlspecialchars($vak_details['naam'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="gebruiker_id">Gebruiker ID</label>
            <input type="text" class="form-control" id="gebruiker_id" name="gebruiker_id" value="<?php echo htmlspecialchars($vak_details['gebruiker_id'] ?? ''); ?>" required>
        </div>

        <input type="hidden" name="vak_id" value="<?php echo $vak_id; ?>">
        <button type="submit" class="btn btn-primary" name="updateVak">Update Vak</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include_once('../../includes/footer.php'); ?>
