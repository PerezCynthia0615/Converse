<?php
include("conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre    = $_POST['nombre'];
    $telefono  = $_POST['telefono'];
    $email     = $_POST['email'];
    $cantidad  = $_POST['cantidad'];
    $direccion = $_POST['direccion'];
    $ciudad    = $_POST['ciudad'];
    $cp        = $_POST['cp'];
    $pago      = $_POST['pago'];
    $notas     = $_POST['notas'];
    $txt_pago = ($pago == "1") ? "Transferencia bancaria" : "Paypal";
    $stmt = $conexion->prepare("INSERT INTO compras (nombre, telefono, email, cantidad, direccion, ciudad, cp, pago, notas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisssss", $nombre, $telefono, $email, $cantidad, $direccion, $ciudad, $cp, $txt_pago, $notas);
    if ($stmt->execute()) {
        echo "<script>alert('¡Compra realizada con éxito!'); window.location.href='index.html';</script>";
    } else {
        echo "Error al procesar la compra: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>