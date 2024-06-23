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
            <!-- Additional navigation items will be injected here by JavaScript -->
        </ul>
    </div>
 
    <script>
        // Simulate the role of the user (manager, roostermaker, docent, undefined)
        var userRole = 'undefined'; // Change the role here as needed

        var navLinks = document.getElementById('navLinks');

        if (userRole === 'manager') {
            addNavigationItem('Docenten', '/database_eindopd/Main-elements/Leraren/DocentData.php');
            addNavigationItem('RoosterData', '/database_eindopd/Main-elements/Rooster/RoosterData.php');
            addNavigationItem('Profiel', '/database_eindopd/Main-elements/Gebruiker/GebruikerData.php');
            addNavigationItem('Logout', '/database_eindopd/Main-elements/Login/logout.php');
        } else if (userRole === 'roostermaker') {
            addNavigationItem('Roosters', '/database_eindopd/Main-elements/Rooster/Roosters.php');
            addNavigationItem('RoosterData', '/database_eindopd/Main-elements/Rooster/RoosterData.php');
            addNavigationItem('Profiel', '/database_eindopd/Main-elements/Gebruiker/GebruikerData.php');
            addNavigationItem('Logout', '/database_eindopd/Main-elements/Login/logout.php');
        } else if (userRole === 'docent') {
            addNavigationItem('Docenten', '/database_eindopd/Main-elements/Leraren/DocentData.php');
            addNavigationItem('Klassen', '/database_eindopd/Main-elements/Klassen/KlassenData.php');
            addNavigationItem('Vakken', '/database_eindopd/Main-elements/Vakken/VakkenData.php');
            addNavigationItem('Profiel', '/database_eindopd/Main-elements/Gebruiker/GebruikerData.php');
            addNavigationItem('Student', '/database_eindopd/Main-elements/Studenten/StudentData.php');
            addNavigationItem('Roosters', '/database_eindopd/Main-elements/Rooster/Roosters.php');
            addNavigationItem('Logout', '/database_eindopd/Main-elements/Login/logout.php');
        } else { // Default or undefined role
            addNavigationItem('Roosters', '/database_eindopd/Main-elements/Rooster/Roosters.php');
            addNavigationItem('Logout', '/database_eindopd/Main-elements/Login/logout.php');
        }

        function addNavigationItem(label, link) {
            navLinks.innerHTML += '<li><a href="' + link + '" style="color: white; text-decoration: none;">' + label + '</a></li>';
        }
    </script>
</body>
</html>
