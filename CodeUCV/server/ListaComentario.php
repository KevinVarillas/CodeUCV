<?php
require_once("../server/php/conexion_be.php");
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

$query = "SELECT c.id AS comentario_id, c.nombre_usuario, c.comentarios, c.respuesta, c.fecha, c.categoria,
                 r.idrespuesta AS respuesta_id, r.nombre_usuario AS respuesta_usuario, r.reply_comment AS respuesta_comentario, r.fecha_respuesta
          FROM comentarios c
          LEFT JOIN respuestasforo r ON c.id = r.parent_comment_id
          WHERE c.categoria = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $categoria);
$stmt->execute();
$result = $stmt->get_result();

$comments = array();
while ($row = $result->fetch_assoc()) {
    if (!isset($comments[$row['comentario_id']])) {
        $comment = array(
            'id' => $row['comentario_id'],
            'nombre_usuario' => $row['nombre_usuario'],
            'comentarios' => $row['comentarios'],
            'respuesta' => $row['respuesta'],
            'fecha' => $row['fecha'],
            'categoria' => $row['categoria'],
            'respuestas' => array()
        );
        $comments[$row['comentario_id']] = $comment;
    }

    if (!empty($row['respuesta_id'])) {
        $respuesta = array(
            'id' => $row['respuesta_id'],
            'nombre_usuario' => $row['respuesta_usuario'],
            'reply_comment' => $row['respuesta_comentario'],
            'fecha_respuesta' => $row['fecha_respuesta']
        );
        $comments[$row['comentario_id']]['respuestas'][] = $respuesta;
    }
}

header('Content-Type: application/json');
echo json_encode(array_values($comments));

$stmt->close();
$conexion->close();
?>
