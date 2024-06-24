<?php
//database_eindopd/Main-elements/Login/logout.php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: /database_eindopd/Main-elements/Login/loginPage.php");
exit;
 
