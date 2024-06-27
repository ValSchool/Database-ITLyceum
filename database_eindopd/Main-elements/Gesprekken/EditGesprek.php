<?php
session_start();

require_once '../../Db_connection.php';
require_once '../Gesprekken/Gesprek.php';

$myDb = new DB('itlyceum');
$Gesprekken = new Gesprekken($myDb);

$gesprek_id = $_GET['gesprek_id'] ?? null;
$gesprek_details = [];

// Fetch gesprek details based on gesprek_id
if ($gesprek_id) {
    $gesprek_details = $Gesprekken->getGesprek($gesprek_id);
}

// Handle form submission for updating gesprek details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateGesprek'])) {
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $onderwerp = $_POST['onderwerp'];
    $beschrijving = $_POST['beschrijving'];

    try {
        // Perform the update operation
        $result = $Gesprekken->updateGesprek($gesprek_id, $datum, $tijd, $onderwerp, $beschrijving);

        if ($result) {
            // Redirect to GesprekkenData.php after successful edit
            header("Location: GesprekkenData.php");
            exit();
        } else {
            throw new Exception('Failed to update gesprek.');
        }
    } catch (Exception $e) {
        $error_message = 'Error: ' . $e->getMessage();
    }
}
?>

<?php include_once('../../includes/header.php'); ?>

<div class="container">
    <h1>Edit Gesprek</h1>

    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="editGesprek.php?gesprek_id=<?= htmlspecialchars($gesprek_id) ?>">
        <div class="form-group">
            <label for="datum">Datum</label>
            <input type="date" class="form-control" id="datum" name="datum" value="<?php echo htmlspecialchars($gesprek_details['datum'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="tijd">Tijd</label>
            <input type="time" class="form-control" id="tijd" name="tijd" value="<?php echo htmlspecialchars($gesprek_details['tijd'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="onderwerp">Onderwerp</label>
            <input type="text" class="form-control" id="onderwerp" name="onderwerp" value="<?php echo htmlspecialchars($gesprek_details['onderwerp'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="beschrijving">Beschrijving</label>
            <textarea class="form-control" id="beschrijving" name="beschrijving" required><?php echo htmlspecialchars($gesprek_details['beschrijving'] ?? ''); ?></textarea>
        </div>
        
        <input type="hidden" name="gesprek_id" value="<?php echo htmlspecialchars($gesprek_id); ?>">
        <button type="submit" class="btn btn-primary" name="updateGesprek">Update Gesprek</button>
        <a href="GesprekkenData.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include_once('../../includes/footer.php'); ?>
