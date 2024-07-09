<?php
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['id'])) {
    $proyectoId = $data['id'];
    include_once "../php/conexion_be.php";


    if ($conexion->connect_error) {
        http_response_code(500);
        echo json_encode(['error' => 'Error de conexión a la base de datos']);
        exit;
    }
    $proyectoId = $conexion->real_escape_string($proyectoId);
    $sql = "DELETE FROM posts WHERE id = $proyectoId";

    if ($conexion->query($sql) === TRUE) {
        http_response_code(200); 
        echo json_encode(['message' => 'Publicación eliminada correctamente.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar la publicación: ' . $conexion->error]);
    }
    $conexion->close();
} else {
    http_response_code(400); 
    echo json_encode(['error' => 'Datos JSON no válidos']);
}
?>