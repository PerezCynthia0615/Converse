<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre    = $_POST['nombre'];
    $edad      = $_POST['edad'];
    $genero    = $_POST['genero']; 
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm-password'];
    $telefono  = $_POST['telefono'];
    // Validar contraseña
    if ($password !== $confirm) {
        echo "<script>alert('Las contraseñas no coinciden'); window.location.href='registrate.html';</script>";
        exit();
    }
    $txt_genero = ($genero == "1") ? "Femenino" : "Masculino";
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    // Preparar la consulta
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, edad, genero, email, password, telefono) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $nombre, $edad, $txt_genero, $email, $password_hashed, $telefono);
    if ($stmt->execute()) {
        echo "<script>alert('¡Registro exitoso! Ya puedes iniciar sesión.'); window.location.href='iniciarsesion.html';</script>";
    } else {
        echo "Error al registrar: " . $stmt->error;
    }
    $stmt->close();
    $conexion->close();
}
?>