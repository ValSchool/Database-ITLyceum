<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITLyceum Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2C3E50;
            color: white;
            padding: 20px 0;
            overflow-y: auto;
        }
        .sidebar .logo {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 10px 20px;
            cursor: pointer;
            position: relative;
        }
        .sidebar ul li:hover {
            background-color: #34495E;
        }
        .sidebar ul li ul {
            display: none;
            list-style: none;
            padding: 0;
            background-color: #34495E;
        }
        .sidebar ul li ul li {
            padding: 10px 40px;
        }
        .sidebar ul li:hover ul {
            display: block;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">IT Lyceum</div>
        <ul id="navLinks">
            <li><a href="/database_eindopd/index.php" style="color: white; text-decoration: none;">Home</a></li>
            <?php
                // Simulate the logged-in state and user role
                $isLoggedIn = true; // Change to false to simulate logged-out state
                $userRole = "docent"; // Change to "roostermaker", "docent", "undefined","manager", 

                if ($isLoggedIn) {
                    if ($userRole === "manager") {
                        echo '<li><a href="/database_eindopd/Main-elements/Leraren/DocentData.php" style="color: white; text-decoration: none;">Docenten</a></li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Rooster/RoosterData.php" style="color: white; text-decoration: none;">RoosterData</a></li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Gebruiker/GebruikerData.php" style="color: white; text-decoration: none;">Profiel</a>';
                        echo '  <ul>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gebruiker/GebruikerData.php" style="color: white; text-decoration: none;">profiel</a></li>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gebruiker/DisplayGebruikers.php" style="color: white; text-decoration: none;">collegas</a></li>';
                        echo '  </ul>';
                        echo '</li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Login/logout.php" style="color: white; text-decoration: none;">Logout</a></li>';
                    } elseif ($userRole === "roostermaker") {
                        echo '<li><a href="/database_eindopd/Main-elements/Rooster/RoosterData.php" style="color: white; text-decoration: none;">RoosterData</a></li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Rooster/Roosters.php" style="color: white; text-decoration: none;">Roosters</a></li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Gebruiker/GebruikerData.php" style="color: white; text-decoration: none;">Profiel</a>';
                        echo '  <ul>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gebruiker/GebruikerData.php" style="color: white; text-decoration: none;">profiel</a></li>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gebruiker/DisplayGebruikers.php" style="color: white; text-decoration: none;">collegas</a></li>';
                        echo '  </ul>';
                        echo '</li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Login/logout.php" style="color: white; text-decoration: none;">Logout</a></li>';
                    } elseif ($userRole === "docent") {
                        echo '<li><a href="/database_eindopd/Main-elements/Leraren/DocentData.php" style="color: white; text-decoration: none;">Docenten</a></li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Klassen/KlassenData.php" style="color: white; text-decoration: none;">Klassen</a>';
                        echo '  <ul>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Klassen/KlassenData.php" style="color: white; text-decoration: none;">KlassenData</a></li>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Klassen/AddKlassen.php" style="color: white; text-decoration: none;">AddKlassen</a></li>';
                        echo '  </ul>';
                        echo '</li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Vakken/VakkenData.php" style="color: white; text-decoration: none;">Vakken</a>';
                        echo '  <ul>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Vakken/VakkenData.php" style="color: white; text-decoration: none;">VakkenData</a></li>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Vakken/AddVakken.php" style="color: white; text-decoration: none;">AddVakken</a></li>';
                        echo '  </ul>';
                        echo '</li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Gesprekken/GesprekkenData.php" style="color: white; text-decoration: none;">Gesprek</a>'; 
                        echo '  <ul>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gesprekken/GesprekkenData.php" style="color: white; text-decoration: none;">Gesprekken</a></li>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gesprekken/AddGesprek.php" style="color: white; text-decoration: none;">AddGesprekken</a></li>';
                        echo '  </ul>';
                        echo '</li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Studenten/StudentData.php" style="color: white; text-decoration: none;">Student</a></li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Gebruiker/GebruikerData.php" style="color: white; text-decoration: none;">Profiel</a>';
                        echo '  <ul>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gebruiker/GebruikerData.php" style="color: white; text-decoration: none;">profiel</a></li>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Gebruiker/DisplayGebruikers.php" style="color: white; text-decoration: none;">collegas</a></li>';
                        echo '  </ul>';
                        echo '</li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Klassen/KlassenData.php" style="color: white; text-decoration: none;">Klassen</a>';
                        echo '  <ul>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Klassen/KlassenData.php" style="color: white; text-decoration: none;">KlassenData</a></li>';
                        echo '      <li><a href="/database_eindopd/Main-elements/Klassen/AddKlassen.php" style="color: white; text-decoration: none;">AddKlassen</a></li>';
                        echo '  </ul>';
                        echo '<li><a href="/database_eindopd/Main-elements/Login/logout.php" style="color: white; text-decoration: none;">Logout</a></li>';
                    } else {
                        echo '<li><a href="/database_eindopd/Main-elements/Rooster/Roosters.php" style="color: white; text-decoration: none;">Roosters</a></li>';
                        echo '<li><a href="/database_eindopd/Main-elements/Login/logout.php" style="color: white; text-decoration: none;">Logout</a></li>';
                    }
                } else {
                    echo '<li><a href="/database_eindopd/Main-elements/Login/loginPage.php" style="color: white; text-decoration: none;">Login</a></li>';
                    echo '<li><a href="/database_eindopd/Main-elements/Register/RegisterPage.php" style="color: white; text-decoration: none;">Register</a></li>';
                }
            ?>
        </ul>
    </div>
</body>
</html>
