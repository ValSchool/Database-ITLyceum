<?php
session_start();

require_once 'Student.php';  // Include the Student class
require_once '../../Db_connection.php'; // Include the DB class (assuming it handles database connection)

// Initialize DB connection
$myDb = new DB('itlyceum'); // Adjust the database name ('itlyceum') as per your configuration
$student = new Student($myDb); // Create instance of Student class

// Function to fetch all students
$students = $student->selectStudenten();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Student Data</h2>
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success_message']; ?>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Class ID</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($student['klas_id']); ?></td>
                                <td><?php echo htmlspecialchars($student['naam']); ?></td>
                                <td><?php echo htmlspecialchars($student['achternaam']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td>
                                    <a href="edit_student.php?student_id=<?php echo $student['student_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="delete_student.php?student_id=<?php echo $student['student_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
