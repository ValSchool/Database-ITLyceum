<?php
//database_eindopd/Main-elements/Login/loginPage.php
// Start the session
session_start();

require_once('Login.php'); // Include the Login class file
require_once'../../Db_connection.php';

$myDb = new DB('itlyceum');
// Initialize variables
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email']; // Changed from $email to $email for consistency
    $password_hash = $_POST['password'];

    // Instantiate the Login class with PDO instance
    $login = new Login($myDb);

    // Attempt to log in the user
    $student = $login->loginStudent($email, $password_hash);

    // Check if login was successful
    if ($student) {
        // Set session variable
        $_SESSION['email'] = $student['email']; // Store the email in the session

        // Redirect to home page or dashboard
        header("Location: ../../index.php"); // Change to appropriate page
        exit();
    } else {
        // Login failed, display error message
        $errorMessage = "Incorrect email or password. Please try again.";
    }
}
?>

<?php include_once('../../includes/header.php'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Login</h2>
                    <!-- Display error message if login failed -->
                    <?php if (!empty($errorMessage)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action=""> <!-- Specify the action attribute -->
                        <div class="form-group">
                            <label for="email">Email</label> <!-- Changed the label to 'email' for consistency -->
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-block">Login</button>
                    </form>
                    <p class="text-center mt-3">Other login options: <a href="/database_eindopd/Main-elements/login/SpecialLoginPage.php">admin</a></p>
                    <p class="text-center mt-3">Don't have an account? <a href="../Register/RegisterPage.php">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('../../includes/footer.php'); ?>