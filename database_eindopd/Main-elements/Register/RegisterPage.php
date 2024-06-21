<?php
require_once 'Register.php'; // Include the Register class
require_once '../../Db_connection.php';

// Create a new instance of the DB class
$myDb = new DB('itlyceum');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $achternaam = htmlspecialchars($_POST['achternaam']);

    // Create a new instance of the Register class, passing the DB instance
    $register = new Register($myDb);

    // Attempt to register the user
    $registrationSuccess = $register->registerUser($username, $achternaam, $password);

    if ($registrationSuccess) {
        // Redirect to login page
        header("Location: /database_eindopd/Main-elements/Login/loginPage.php");
        exit();
    } else {
        // Display error message
        $errorMessage = "Failed to register. Please try again.";
    }
}
?>


<?php include_once('../../includes/header.php'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Register</h2>
                    <!-- Display error message if registration failed -->
                    <?php if (isset($errorMessage)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form action="RegisterPage.php" method="post">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group"> <!-- Add this section -->
        <label for="achternaam">Last Name</label>
        <input type="text" class="form-control" id="achternaam" name="achternaam" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

   

    <button type="submit" class="btn btn-secondary btn-block">Register</button>
</form>
                    <p class="text-center mt-3">Other login options: <a href="/database_eindopd/Main-elements/login/SpecialLoginPage.php">admin</a></p>
                    <p class="text-center mt-3">Already have an account? <a href="/database_eindopd/Main-elements/login/LoginPage.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('../../includes/footer.php'); ?>
