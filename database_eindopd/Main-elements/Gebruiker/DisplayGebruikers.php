<?php
// Start session to retrieve email
session_start();

// Include database connection and Gebruiker class
require_once '../../Db_connection.php';
require_once '../Gebruiker/Gebruiker.php';

// Initialize database connection
$myDb = new DB('itlyceum');

// Instantiate Gebruiker class
$gebruikerData = new Gebruiker($myDb);

// Fetch all gebruikers
$allGebruikers = $gebruikerData->selectAllGebruikers();

// Include header
include_once('../../includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikers Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Gebruikers Data</h1>
        
        <?php if (!empty($allGebruikers)): ?>
            <table class="table mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Rol</th>
                        <!-- Add more fields as needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allGebruikers as $gebruiker): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($gebruiker['email']); ?></td>
                            <td><?php echo htmlspecialchars($gebruiker['naam']); ?></td>
                            <td><?php echo htmlspecialchars($gebruiker['rol']); ?></td>
                            <!-- Add more columns here as per your database schema -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning mt-3" role="alert">
                No gebruikers found.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Include footer if needed
include_once('../../includes/footer.php');
?>
