<?php
$host = "mysql-pleya.alwaysdata.net";
$user = "pleya";
$pass = "Misifu123+";
$db = "pleya_envios";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
