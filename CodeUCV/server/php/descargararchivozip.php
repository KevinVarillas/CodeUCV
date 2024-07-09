<?php
session_start();
require_once("conexion_be.php");

if (!isset($_SESSION['nombre_usuario'])) {
    http_response_code(401); // Unauthorized
    exit('No autorizado. Por favor inicia sesión.');
}

if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    exit('ID del proyecto no especificada');
}

$id_proyecto = $_GET['id'];

// Consultar la base de datos para obtener la ruta del archivo ZIP
$sql = "SELECT archivo_zip FROM posts WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_proyecto);
$stmt->execute();
$stmt->bind_result($ruta_archivo); // Suponiendo que 'archivo_zip' contiene la ruta relativa o el nombre del archivo ZIP
$stmt->fetch();
$stmt->close();

if (!$ruta_archivo) {
    http_response_code(404); // Not Found
    exit('Archivo ZIP no encontrado');
}

// Devolver la ruta del archivo ZIP como texto
echo $ruta_archivo;
?>
