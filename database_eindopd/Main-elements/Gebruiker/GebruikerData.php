<?php
// Start session to retrieve email
session_start();

// Include database connection and Gebruiker class
require_once '../../Db_connection.php';
require_once '../Gebruiker/Gebruiker.php';

// Initialize database connection
$myDb = new DB('itlyceum');

// Check if email is set in session
if (isset($_SESSION['email'])) {
    // Fetch gebruiker data based on email
    $email = $_SESSION['email'];
    
    // Instantiate Gebruiker class and fetch gebruiker details by email
    $gebruikerData = new Gebruiker($myDb);
    $gebruiker = $gebruikerData->selectGebruikerDataByEmail($email);

    // Check if gebruiker data was fetched
    if ($gebruiker) {
        include_once('../../includes/header.php');
        // HTML output to display gebruiker data
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gebruiker Data</title>
            <!-- Bootstrap CSS -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <div class="container">
            <h1>Gebruiker Data</h1>
            <div class="card">
                <div class="card-header">
                    Gebruiker Details
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($gebruiker['naam']); ?></h5>
                    <p class="card-text">
                        <strong>Email:</strong> <?php echo htmlspecialchars($gebruiker['email']); ?><br>
                       
                        <strong>Rol:</strong> <?php echo htmlspecialchars($gebruiker['rol']); ?><br>
                        <!-- Add more fields as needed -->
                    </p>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        // Display error if gebruiker data is not found
        ?>
        
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gebruiker Data</title>
            <!-- Bootstrap CSS -->
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <div class="container">
            <h1>Gebruiker Data</h1>
            <div class="alert alert-danger" role="alert">
                Gebruiker not found or data retrieval error.
            </div>
        </div>

        <!-- Bootstrap JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    }
} else {
    // Handle case where email is not set in session
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gebruiker Data</title>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container">
        <h1>Gebruiker Data</h1>
        <div class="alert alert-danger" role="alert">
            Email not set in session.
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
}


?>
<?php include_once('../../includes/footer.php'); ?>
