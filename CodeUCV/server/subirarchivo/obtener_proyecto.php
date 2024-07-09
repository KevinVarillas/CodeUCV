<?php
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['id'])) {
    $proyectoId = $data['id'];

    include_once "../php/conexion_be.php";

    $proyectoId = mysqli_real_escape_string($conexion, $proyectoId);
    $sql = "DELETE FROM posts WHERE id = $proyectoId";

    if (mysqli_query($conexion, $sql)) {
        http_response_code(200);
        echo json_encode(['message' => 'Publicación eliminada correctamente.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar la publicación: ' . mysqli_error($conexion)]);
    }

    mysqli_close($conexion);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Datos JSON no válidos']);
}
?>
