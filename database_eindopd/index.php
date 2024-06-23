<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    
    header("Location: /database_eindopd/Main-elements/Login/LoginPage.php");
}

// Retrieve user information only if logged in
$email = $_SESSION['email'];
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'Role not defined'; // Provide a default value if role is not set

// Include header
include_once('../database_eindopd/includes/header.php');
?>

<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($email); ?>!</h1>
    <p>Your role is: <?php echo htmlspecialchars($rol); ?></p>
</div>


<?php include_once('../database_eindopd/includes/footer.php'); ?>
