<?php
session_start();

require_once 'Student.php';  // Include the Student class
require_once '../../Db_connection.php'; // Include the DB class (assuming it handles database connection)

// Initialize DB connection
$myDb = new DB('itlyceum'); // Adjust the database name ('itlyceum') as per your configuration
$student = new Student($myDb); // Create instance of Student class

// Variables to store form data and errors
$klas_id = $naam = $achternaam = $email = $password = '';
$errors = [];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs (you can add more validation as needed)
    $klas_id = $_POST['klas_id'];
    $naam = $_POST['naam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Example basic validation (you should add more specific validation as per your requirements)
   // if (empty($student_id)) {
    //    $errors[] = 'Student ID is required.';
    //}
    if (empty($naam)) {
        $errors[] = 'Name is required.';
    }
    if (empty($achternaam)) {
        $errors[] = 'Last name is required.';
    }
   // if (empty($email)) {
      //  $errors[] = 'Email is required.';
    //}
    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    // If no errors, insert the student into database
    if (empty($errors)) {
        // Call insertStudent method from Student class
        $result = $student->insertStudent($klas_id, $naam, $achternaam, $email, $password);

        if ($result) {
            // Student inserted successfully
            $_SESSION['success_message'] = 'Student inserted successfully.';
            header('Location: StudentData.php'); // Redirect to students list or another page
            exit();
        } else {
            $errors[] = 'Failed to insert student. Please try again.';
        }
    }
}

?>
<?php include_once('../../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>Insert Student</h2>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="klas_id">Class ID:</label>
                        <input type="text" class="form-control" id="klas_id" name="klas_id" value="<?php echo htmlspecialchars($klas_id); ?>">
                    </div>
                    <div class="form-group">
                        <label for="naam">Name:</label>
                        <input type="text" class="form-control" id="naam" name="naam" value="<?php echo htmlspecialchars($naam); ?>">
                    </div>
                    <div class="form-group">
                        <label for="achternaam">Last Name:</label>
                        <input type="text" class="form-control" id="achternaam" name="achternaam" value="<?php echo htmlspecialchars($achternaam); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
