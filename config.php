<?php

$server = 'localhost';
$userdb = 'root';
$passworddb = '';
$dbname = 'employee';

$mysqli = new mysqli($server, $userdb, $passworddb, $dbname);

if($mysqli === false){
    die('Error for server' . $mysqli->connect_error);
}

?>