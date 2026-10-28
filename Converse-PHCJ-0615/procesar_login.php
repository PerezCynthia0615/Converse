<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($usuario = $resultado->fetch_assoc()) {
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            echo "<script>
                localStorage.setItem('usuarioNombre', '" . addslashes($usuario['nombre']) . "');
                alert('¡Bienvenido, " . addslashes($usuario['nombre']) . "!');
                window.location.href = 'index.html';
            </script>";
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location.href='iniciarsesion.html';</script>";
        }
    } else {
        echo "<script>alert('El correo no está registrado'); window.location.href='iniciarsesion.html';</script>";
    }
    $stmt->close();
    $conexion->close();
}
?>