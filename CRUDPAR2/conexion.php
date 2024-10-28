<?php
$host = "localhost";
$user = "root"; // Usuario MySQL
$password = ""; // Contraseña MySQL
$dbname = "ventas_db";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
