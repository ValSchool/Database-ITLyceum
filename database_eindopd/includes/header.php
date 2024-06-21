<?php

// Check if a session is not already active


// Check if the user is logged in
$isLoggedIn = isset($_SESSION['email']);

// Define navigation links
$navLinks = array(
    array('url' => '/database_eindopd/index.php', 'text' => 'Home'),
   
); 

// Add logout link if logged in
if ($isLoggedIn) {
    $navLinks[] = array('url' => '/database_eindopd/Main-elements/Leraren/DocentData.php', 'text' => 'Docenten');
    $navLinks[] = array('url' => '/database_eindopd/Main-elements/Login/logout.php', 'text' => 'Logout');

} else {
    // Add login and register links if not logged in
    $navLinks[] = array('url' => '/database_eindopd/Main-elements/Login/loginPage.php', 'text' => 'Login');
    $navLinks[] = array('url' => '/database_eindopd/Main-elements/Register/RegisterPage.php', 'text' => 'Register');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITLyceum</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">IT lyceum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <?php
            // Loop through navigation links and display them
            foreach ($navLinks as $link) {
                echo "<li class='nav-item'><a class='nav-link' href='{$link['url']}'>{$link['text']}</a></li>";
            }
            ?>
        </ul>
    </div>
</nav>

<div class="container">
    <!-- Your page content goes here -->
</div>

</body>
</html>
