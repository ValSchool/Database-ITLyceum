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
?>
<?php include_once('../../includes/header.php'); ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
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

   
        </table>
    </div>
</div>
</body>
<?php include_once('../../includes/footer.php'); ?>