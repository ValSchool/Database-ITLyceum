<?php
session_start();

require_once '../Rooster/Rooster.php';
require_once '../../Db_connection.php';
require_once '../Klassen/Klassen.php';
require_once '../Vakken/Vakken.php';

$myDb = new DB('itlyceum');
$rooster = new Rooster($myDb);
$klassen = new Klassen($myDb);
$vakken = new Vakken($myDb);

// Fetch all classes for the dropdown
$allKlassen = $klassen->selectKlassen();

// Initialize $klas_id if needed, for example from a GET parameter or session
$klas_id = isset($_GET['klas_id']) ? $_GET['klas_id'] : (isset($_SESSION['klas_id']) ? $_SESSION['klas_id'] : null);
$naam = isset($_GET['naam ']) ? $_GET['naam '] : (isset($_SESSION['naam ']) ? $_SESSION['naam '] : null);
// Handle form submission for adding a new schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addRooster'])) {
    $klas_id = $_POST['klas_id'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $vak_id = $_POST['vak_id'];
    $gebruiker_id = $_POST['gebruiker_id'];
    $rooster->insertRoosterForNextWeek($klas_id, $datum, $tijd, $vak_id, $gebruiker_id);
}

// Handle form submission for editing a schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editRooster'])) {
    $rooster_id = $_POST['rooster_id'];
    $klas_id = $_POST['klas_id'];
    $weeknummer = $_POST['weeknummer'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $vak_id = $_POST['vak_id'];
    $gebruiker_id = $_POST['gebruiker_id'];
    $rooster->editRooster($rooster_id, $klas_id, $weeknummer, $datum, $tijd, $vak_id, $gebruiker_id);
}

// Handle form submission for deleting a schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteRooster'])) {
    $rooster_id = $_POST['rooster_id'];
    $rooster->deleteRooster($rooster_id);
}

// Fetch schedules for the selected class and week
$allRoosters = [];
if ($klas_id) {
    // Fetch schedules for the selected week (if provided)
    $weeknummer = isset($_GET['weeknummer']) ? $_GET['weeknummer'] : date('W'); // Default to current week
    $allRoosters = $rooster->selectRoostersByKlasAndWeek($klas_id, $weeknummer);
    $_SESSION['klas_id'] = $klas_id; // Store the selected class ID in session
}
?>

<?php include_once('../../includes/header.php'); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <!-- Side menu with class dropdown -->
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <a class="navbar-brand" href="#">Menu</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="klasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select Class
                            </a>
                            <div class="dropdown-menu" aria-labelledby="klasDropdown">
                                <?php foreach ($allKlassen as $klas) : ?>
                                    <a class="dropdown-item" href="?klas_id=<?php echo $klas['klas_id']; ?>"><?php echo htmlspecialchars($klas['naam']); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-md-10">
            <h1>Rooster Management</h1>
            
            <?php if ($klas_id): ?>
    <h2>Current Roosters for Class ID: <?php echo htmlspecialchars($klas_id); ?></h2>

    <!-- Week Navigation -->
    <div class="mb-3">
        <form class="form-inline" method="GET" action="process_form.php">
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

                <div class="row">
                    <div class="col-md-3">
                        <form method="post" action="">
                            <h2>Add New Rooster</h2>
                            <input type="hidden" name="klas_id" value="<?php echo $klas_id; ?>">
                            <div class="form-group">
                                <label for="datum">Datum</label>
                                <input type="date" class="form-control" id="datum" name="datum" required>
                            </div>
                            <div class="form-group">
                                <label for="tijd">Tijd</label>
                                <input type="time" class="form-control" id="tijd" name="tijd" required>
                            </div>
                            <div class="form-group">
                                <label for="vak_id">Vak ID</label>
                                <input type="number" class="form-control" id="vak_id" name="vak_id" required>
                            </div>
                            <div class="form-group">
                                <label for="gebruiker_id">Gebruiker ID</label>
                                <input type="number" class="form-control" id="gebruiker_id" name="gebruiker_id" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="addRooster">Add Rooster</button>
                        </form>
                    </div>
                    <div class="col-md-9">
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
                                                            <form method="post" action="" style="display:inline;">
                                                                <input type="hidden" name="rooster_id" value="<?php echo $rooster['rooster_id']; ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm" name="deleteRooster">Delete</button>
                                                            </form>
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
                </div>
            <?php else: ?>
                <p>Please select a class to view and manage the schedule.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php include_once('../../includes/footer.php'); ?>
