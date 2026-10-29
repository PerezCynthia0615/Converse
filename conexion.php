<?php
// Datos para identificarnos con la base de datos
$host = "localhost";      // La base de datos está en esta misma computadora
$user = "root";           // Nombre del usuario de la base de datos
$password = "";           // Contraseña (en XAMPP viene sin contraseña)
$database = "tienda_converse"; // El nombre de la base de datos a la que nos conectaremos
// Abrimos la puerta y nos conectamos a la base de datos
$conexion = new mysqli($host, $user, $password, $database);
// Revisamos si la conexión falló
if ($conexion->connect_error) {
    // Si hubo error, detenemos todo y mostramos un mensaje explicativo
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}
// Le decimos a la base de datos que acepte acentos, eñes y caracteres especiales
$conexion->set_charset("utf8");
?>