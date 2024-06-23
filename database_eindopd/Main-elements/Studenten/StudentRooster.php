<?php
session_start();

require_once '../Rooster/Rooster.php';
require_once '../../Db_connection.php';
require_once '../Klassen/Klassen.php';
require_once '../Vakken/Vakken.php';

// Assume that student information is stored in the session
// For example, $_SESSION['student_id'] and $_SESSION['klas_id']
if (!isset($_SESSION['student_id']) || !isset($_SESSION['klas_id'])) {
    // Redirect to login or error page if student is not authenticated or class ID is not set
    header("Location:/database_eindopd/Main-elements/login/LoginPage.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$klas_id = $_SESSION['klas_id'];

$myDb = new DB('itlyceum');
$rooster = new Rooster($myDb);
$klassen = new Klassen($myDb);
$vakken = new Vakken($myDb);

// Fetch schedules for the student's class
$weeknummer = isset($_GET['weeknummer']) ? $_GET['weeknummer'] : date('W'); // Default to current week
$allRoosters = $rooster->selectRoostersByKlasAndWeek($klas_id, $weeknummer);
?>

<?php include_once('/database_eindopd/Main-elements/login/LoginPage.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Rooster</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>My Rooster</h1>
    <h2>Class ID: <?php echo htmlspecialchars($klas_id); ?></h2>

    <!-- Week Navigation -->
    <div class="mb-3">
        <form class="form-inline">
            <label class="my-1 mr-2" for="weeknummer">Select Week:</label>
            <select class="custom-select my-1 mr-sm-2" id="weeknummer" name="weeknummer" onchange="this.form.submit()">
                <?php
                // Generate options for weeks
                for ($i = 1; $i <= 52; $i++) {
                    $selected = ($weeknummer == $i) ? 'selected' : '';
                    echo "<option value='$i' $selected>Week $i</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary my-1">Go</button>
        </form>
    </div>

    <!-- Timetable layout -->
    <h2>Timetable - Week <?php echo $weeknummer; ?></h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time</th>
                    <?php for ($i = 0; $i < 7; $i++): ?>
                        <th><?php echo date('l', strtotime("Sunday +$i days")); ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $times = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'];
                foreach ($times as $time):
                ?>
                <tr>
                    <td><?php echo $time; ?></td>
                    <?php for ($i = 0; $i < 7; $i++): ?>
                        <td>
                            <?php
                            $day = date('Y-m-d', strtotime("Sunday +$i days"));
                            foreach ($allRoosters as $rooster):
                                if ($rooster['datum'] == $day && $rooster['tijd'] == $time):
                                    $vak = $vakken->selectVakById($rooster['vak_id']); // Fetch vak details
                            ?>
                                    <div>
                                        <strong>Vak:</strong> <?php echo htmlspecialchars($vak['naam']); ?><br>
                                        <strong>Gebruiker ID:</strong> <?php echo htmlspecialchars($rooster['gebruiker_id']); ?>
                                    </div>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </td>
                    <?php endfor; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php include_once('../../includes/footer.php'); ?>
