<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'odbojkarska_liga';

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) {
    die("Napaka pri povezavi: " . mysqli_connect_error());
}
?>
