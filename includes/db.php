<?php
// Archivo: includes/db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "colegio_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
