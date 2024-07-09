<?php
if (isset($_POST['parent_comment_id'], $_POST['nombre_usuario'], $_POST['reply_comment'])) {
    $parent_comment_id = $_POST['parent_comment_id'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $reply_comment = $_POST['reply_comment'];

    file_put_contents('debug_respuesta.log', print_r($_POST, true), FILE_APPEND);
    
    require_once("../server/php/conexion_be.php");
    
    $stmt = $conexion->prepare("INSERT INTO respuestasforo (parent_comment_id, nombre_usuario, reply_comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $parent_comment_id, $nombre_usuario, $reply_comment);

    if ($stmt->execute()) {
        echo "Respuesta agregada correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Error: Datos incompletos.";
}
?>





