<?php
session_start();

require_once 'Docent.php'; // Ensure the path is correct
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$docent = new Docent($myDb);

// Handle form submission for adding a new docent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addDocent'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $docent->insertDocent($naam, $email, $password);
}

// Handle form submission for deleting a docent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteDocent'])) {
    $gebruiker_id = $_POST['gebruiker_id'];
    $docent->deleteDocent($gebruiker_id);
}

// Fetch the latest data from the database
$allDocenten = $docent->selectDocent();
?>

<?php include_once('../../includes/header.php'); ?>

<div class="container">
    <h1>Docent Management</h1>

    <!-- Form to add a new docent -->
    <form method="post" action="">
        <h2>Add New Docent</h2>
        <div class="form-group">
            <label for="naam">Naam</label>
            <input type="text" class="form-control" id="naam" name="naam" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" name="addDocent">Add Docent</button>
    </form>

    <!-- List of current docenten -->
    <h2>Current Docenten</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Gebruiker ID</th>
                <th>Naam</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allDocenten as $docent) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($docent['gebruiker_id']); ?></td>
                    <td><?php echo htmlspecialchars($docent['naam']); ?></td>
                    <td><?php echo htmlspecialchars($docent['email']); ?></td>
                    <td>
                        <a href="EditDocent.php?gebruiker_id=<?php echo $docent['gebruiker_id']; ?>" class="btn btn-warning">Edit</a>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="gebruiker_id" value="<?php echo $docent['gebruiker_id']; ?>">
                            <button type="submit" class="btn btn-danger" name="deleteDocent">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once('../../includes/footer.php'); ?>
