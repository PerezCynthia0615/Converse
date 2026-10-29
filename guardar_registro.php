<?php
// Traemos la conexión a la base de datos para poder usarla aquí
include("conexion.php");
// Verificamos que los datos hayan llegado al enviar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atrapamos cada dato que el usuario escribió en las casillas del formulario
    $nombre    = $_POST['nombre'];
    $edad      = $_POST['edad'];
    $genero    = $_POST['genero']; 
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm-password'];
    $telefono  = $_POST['telefono'];
    // Validamos: ¿Las dos contraseñas escritas son iguales?
    if ($password !== $confirm) {
        // Si NO son iguales, le avisamos con una alerta y lo regresamos a la pantalla de registro
        echo "<script>alert('Las contraseñas no coinciden'); window.location.href='registrate.html';</script>";
        exit(); // Cancelamos todo lo demás
    }
    // Traducimos la opción del género: si seleccionó "1" es Femenino, si no, Masculino
    $txt_genero = ($genero == "1") ? "Femenino" : "Masculino";
    // Encriptamos la contraseña (la convertimos en un código secreto) para no guardarla en texto limpio por seguridad
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    // Preparamos la plantilla de la orden SQL para guardar al usuario de forma segura
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, edad, genero, email, password, telefono) VALUES (?, ?, ?, ?, ?, ?)");    
    // Rellenamos los signos '?' con la información real del usuario
    $stmt->bind_param("sissss", $nombre, $edad, $txt_genero, $email, $password_hashed, $telefono);
    // Ejecutamos la orden y revisamos si se guardó correctamente
    if ($stmt->execute()) {
        // Si se guardó, le mostramos mensaje de éxito y lo mandamos a la página de iniciar sesión
        echo "<script>alert('¡Registro exitoso! Ya puedes iniciar sesión.'); window.location.href='iniciarsesion.html';</script>";
    } else {
        // Si algo salió mal en la base de datos, mostramos el error
        echo "Error al registrar: " . $stmt->error;
    }
    // Cerramos los procesos para no dejar conexiones abiertas innecesariamente
    $stmt->close();
    $conexion->close();
}
?>