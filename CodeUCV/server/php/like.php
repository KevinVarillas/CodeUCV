<?php
include 'conexion_be.php';
session_start();
$usuario = $_SESSION['nombre_usuario'];
$post_id = $_POST['post_id'];
$like = filter_var($_POST['like'], FILTER_VALIDATE_BOOLEAN);

if ($like) {
    // Insertar like en la base de datos
    $sql = "INSERT INTO likes (usuario, post_id) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $usuario, $post_id);
    $stmt->execute();
    $stmt->close();
} else {
    // Eliminar like de la base de datos
    $sql = "DELETE FROM likes WHERE usuario = ? AND post_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $usuario, $post_id);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();
?>
