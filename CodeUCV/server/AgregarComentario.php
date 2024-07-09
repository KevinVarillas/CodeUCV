<?php
require_once("../server/php/conexion_be.php");

if (isset($_POST['comentarios'], $_POST['nombre_usuario'], $_POST['categoria'])) {
    $comentarios = $_POST['comentarios'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $categoria = $_POST['categoria'];

    $stmt = $conexion->prepare("INSERT INTO comentarios (comentarios, nombre_usuario, categoria) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $comentarios, $nombre_usuario, $categoria);

    if ($stmt->execute()) {
        echo "Comentario agregado correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Error: Datos incompletos.";
}
?>
