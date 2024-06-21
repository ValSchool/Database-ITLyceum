<?php
session_start();

include 'SpecialLogin.php'; // Ensure the path is correct


// Initialize the DB connection
$myDb = new DB('itlyceum');

// Initialize variables
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Instantiate the SpecialLogin class with the DB instance
    $login = new SpecialLogin($myDb);

    // Attempt to log in the user
    $gebruiker = $login->loginGebruiker($email, $password);

    // Check if login was successful
    if ($gebruiker) {
        // Set session variables
        $_SESSION['email'] = $gebruiker['email']; // Store the email in the session
        $_SESSION['rol'] = $gebruiker['rol']; // Store the role in the session

        // Redirect to home page or dashboard
        header("Location: ../../index.php");
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
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-block">AdminLogin</button>
                    </form>
                    <p class="text-center mt-3">Are you a student? <a href="/database_eindopd/Main-elements/login/LoginPage.php">Login</a></p>
                   
            </div>
        </div>
    </div>
</div>

<?php include_once('../../includes/footer.php'); ?>
