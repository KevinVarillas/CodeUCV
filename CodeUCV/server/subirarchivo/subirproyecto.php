<?php
session_start();
include '.././php/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Por favor inicia sesión']);
    exit;
}

$nombre_usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'Usuario';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["descripcion"]) || !isset($_FILES["archivo_zip"]) || !isset($_FILES["imagen_portada"])) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos los campos son obligatorios']);
        exit;
    }

    $descripcion = $_POST["descripcion"];
    $archivo_zip = $_FILES["archivo_zip"]["name"];
    $imagen_portada = $_FILES["imagen_portada"]["name"];

    $carpeta_destino = "uploads/";
    move_uploaded_file($_FILES["archivo_zip"]["tmp_name"], $carpeta_destino . $archivo_zip);
    move_uploaded_file($_FILES["imagen_portada"]["tmp_name"], $carpeta_destino . $imagen_portada);

    date_default_timezone_set('America/Lima'); 
    $fecha_publicacion = date("Y-m-d");
    $hora_publicacion = date("H:i:s");

    $sql = "INSERT INTO posts (usuario, descripcion, archivo_zip, imagen_portada, fecha_publicacion, hora_publicacion) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $nombre_usuario, $descripcion, $archivo_zip, $imagen_portada, $fecha_publicacion, $hora_publicacion);

    if ($stmt->execute()) {
        header('Location: ../../client/principal.php');
        exit;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar la publicación en la base de datos']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Método de solicitud no válido']);
}

$conexion->close();
?>
