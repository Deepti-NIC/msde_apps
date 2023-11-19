<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$DB_SERVER = 'localhost';
$DB_USER = 'webAdmin';
$DB_PASS ='Te*m6#p5a';
$DB_NAME = 'nic_farps';
$conn = new mysqli($DB_SERVER,$DB_USER,$DB_PASS,$DB_NAME);
if ($conn->connect_error)
    die ("something went wrong!, please contact to administrator. "
        //  . $con->connect_error 
    );




?>
