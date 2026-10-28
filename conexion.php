<?php
$host = "localhost";
$user = "root";
$password = ""; // Por defecto en XAMPP está vacío
$database = "tienda_converse";

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}
// Establecer el juego de caracteres a UTF-8
$conexion->set_charset("utf8");
?>