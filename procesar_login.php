<?php
// Le decimos a PHP que comience a recordar a este usuario mientras navega en la página
session_start();
// Traemos la conexión a la base de datos
include("conexion.php");
// Verificamos que la información venga del formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atrapamos el correo y contraseña que escribió el usuario
    $email    = $_POST['email'];
    $password = $_POST['password'];
    // Buscamos en la base de datos si existe algún usuario con ese correo
    $stmt = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    // Si encontramos al usuario...
    if ($usuario = $resultado->fetch_assoc()) {
        // Comparamos la contraseña que escribió con la contraseña encriptada de la base de datos
        if (password_verify($password, $usuario['password'])) {
            // ¡Contraseña correcta! Guardamos su ID y su Nombre en la memoria del servidor
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            // Guardamos el nombre en el navegador web, mostramos mensaje de bienvenida e ingresamos al inicio
            echo "<script>
                localStorage.setItem('usuarioNombre', '" . addslashes($usuario['nombre']) . "');
                alert('¡Bienvenido, " . addslashes($usuario['nombre']) . "!');
                window.location.href = 'index.html';
            </script>";
        } else {
            // Si la contraseña no coincide
            echo "<script>alert('Contraseña incorrecta'); window.location.href='iniciarsesion.html';</script>";
        }
    } else {
        // Si el correo no existe en la base de datos
        echo "<script>alert('El correo no está registrado'); window.location.href='iniciarsesion.html';</script>";
    }
    // Cerramos los procesos y la conexión
    $stmt->close();
    $conexion->close();
}
?>