<?php
// Datos de conexión
$servername = "localhost";
$username = "root";      // usuario por defecto en XAMPP
$password = "";          // contraseña vacía por defecto
$dbname = "banorte";      // tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
?>