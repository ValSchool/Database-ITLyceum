<?php
// Include database connection and Gesprekken class
require_once '../../Db_connection.php';
require_once '../Gesprekken/Gesprek.php';

// Initialize database connection
$myDb = new DB('itlyceum');
$Gesprekken = new Gesprekken($myDb);

// Fetch all students to populate the dropdown (assuming you have a students table)
$students = $myDb->exec("SELECT student_id, naam, achternaam FROM studenten");

$student_id = isset($_POST['student_id']) ? $_POST['student_id'] : null;
$gesprekken = [];

if ($student_id) {
    // Fetch conversations for the selected student
    $gesprekken = $Gesprekken->getGesprekkenForStudent($student_id);
}
?>

<?php include_once('../../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesprekken Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Gesprekken Data</h1>
    
    <form method="post" action="GesprekkenData.php" class="mb-4">
        <div class="form-group">
            <label for="student_id">Selecteer Leerling:</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Kies een leerling</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= htmlspecialchars($student['student_id']) ?>" <?= $student_id == $student['student_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($student['naam'] . ' ' . $student['achternaam']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Bekijk Gesprekken</button>
    </form>
    
    <?php if ($student_id && $gesprekken): ?>
        <h2 class="mb-4">Gesprekken voor Leerling ID: <?= htmlspecialchars($student_id) ?></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Gesprek ID</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Onderwerp</th>
                    <th>Beschrijving</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gesprekken as $gesprek): ?>
                    <tr>
                        <td><?= htmlspecialchars($gesprek['gesprek_id']) ?></td>
                        <td><?= htmlspecialchars($gesprek['datum']) ?></td>
                        <td><?= htmlspecialchars($gesprek['tijd']) ?></td>
                        <td><?= htmlspecialchars($gesprek['onderwerp']) ?></td>
                        <td><?= htmlspecialchars($gesprek['beschrijving']) ?></td>
                        <td>
                            <a href="editGesprek.php?gesprek_id=<?= htmlspecialchars($gesprek['gesprek_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form method="post" action="deleteGesprek.php" style="display:inline-block;">
                                <input type="hidden" name="gesprek_id" value="<?= htmlspecialchars($gesprek['gesprek_id']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je dit gesprek wilt verwijderen?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($student_id): ?>
        <p class="alert alert-warning">Geen gesprekken gevonden voor deze leerling.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
