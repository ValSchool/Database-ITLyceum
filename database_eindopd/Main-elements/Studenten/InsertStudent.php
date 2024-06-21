<?php
session_start();

require_once 'Student.php'; 
require_once '../../Db_connection.php';

$myDb = new DB('itlyceum');
$docent = new Docent($myDb);


?>