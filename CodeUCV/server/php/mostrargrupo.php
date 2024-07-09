<?php
session_start();
require_once("conexion_be.php");

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Por favor inicia sesión']);
    exit;
}

$nombre_usuario = $_SESSION['nombre_usuario'];
$sql_usuario_id = "SELECT id FROM usuarios WHERE nombre_usuario = ?";
$stmt_usuario_id = $conexion->prepare($sql_usuario_id);
$stmt_usuario_id->bind_param("s", $nombre_usuario);
$stmt_usuario_id->execute();
$stmt_usuario_id->bind_result($usuario_id);
$stmt_usuario_id->fetch();
$stmt_usuario_id->close();

if (!$usuario_id) {
    http_response_code(500); 
    echo json_encode(['error' => 'Error al obtener información del usuario']);
    exit;
}

$sql_grupos_usuario = "SELECT grupo_id FROM usuario_grupo WHERE usuario_id = ?";
$stmt_grupos_usuario = $conexion->prepare($sql_grupos_usuario);
$stmt_grupos_usuario->bind_param("i", $usuario_id);
$stmt_grupos_usuario->execute();
$result_grupos_usuario = $stmt_grupos_usuario->get_result();

$grupos_usuario = [];
while ($row = $result_grupos_usuario->fetch_assoc()) {
    $grupos_usuario[] = $row['grupo_id'];
}
$stmt_grupos_usuario->close();

$group_id = 2; 
if (!in_array($group_id, $grupos_usuario)) {
    http_response_code(403); 
    echo json_encode(['error' => 'No tienes permisos para ver este grupo']);
    exit;
}

$sql = "SELECT u.nombre_usuario, eu.estado FROM usuarios u
        INNER JOIN usuario_grupo ug ON u.id = ug.usuario_id
        LEFT JOIN estadousuario eu ON u.id = eu.usuarioid
        WHERE ug.grupo_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $group_id);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = [
        'nombre_usuario' => $row['nombre_usuario'],
        'estado' => $row['estado'] ?: 'offline' 
    ];
}

echo json_encode($users);

$stmt->close();
$conexion->close();
?>
