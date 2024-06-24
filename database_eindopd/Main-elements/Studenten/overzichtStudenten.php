<?php
session_start();

require_once 'Student.php'; // Zorg ervoor dat het pad correct is
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$student = new Student($myDb);

try {
    $students = $student->getAllStudents();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Studenten</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Overzicht Studenten</h1>
        <table class="table table-striped">
            
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Klas ID</th>
                    <th>Naam</th>
                    <th>Achternaam</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($student['klas_id']); ?></td>
                            <td><?php echo htmlspecialchars($student['naam']); ?></td>
                            <td><?php echo htmlspecialchars($student['achternaam']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td>
                        <a href="EditStudent.php?student_id=<?php echo $student['student_id']; ?>" class="btn btn-warning">Edit</a>

                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">

                            <a href="DeleteDocenten.php?student_id=<?php echo $student['student_id']; ?>" class="btn btn-danger">Delete</a>
                        </form>
                        </tr>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Geen studenten gevonden.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
