<?php
include_once "../config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT imagen_perfil FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagen_perfil);
    $stmt->fetch();
    $stmt->close();

    // Enviar cabecera de tipo de contenido adecuado
    header("Content-Type: image/jpeg");
    echo $imagen_perfil;
} else {
    echo "ID no especificado";
}
?>
