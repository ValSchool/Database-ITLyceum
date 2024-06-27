<?php
// Include database connection and Gesprekken class
require_once '../../Db_connection.php';
require_once '../Gesprekken/Gesprek.php';

// Initialize database connection
$myDb = new DB('itlyceum');
$Gesprekken = new Gesprekken($myDb);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gesprek_id = $_POST['gesprek_id'];
    $Gesprekken->deleteGesprek($gesprek_id);
    header('Location: GesprekkenData.php');
    exit();
}

