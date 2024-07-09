<?php
session_start();
require_once("conexion_be.php");

if (!isset($_SESSION['nombre_usuario'])) {
    http_response_code(401); 
    echo json_encode(['error' => 'Por favor inicia sesión']);
    exit;
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405); 
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}
$nombre_usuario = $_SESSION['nombre_usuario'];
$sql_usuario = "SELECT id FROM usuarios WHERE nombre_usuario = ?";
$stmt_usuario = $conexion->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $nombre_usuario);
$stmt_usuario->execute();
$stmt_usuario->bind_result($usuario_id);
$stmt_usuario->fetch();
$stmt_usuario->close();

if (!$usuario_id) {
    http_response_code(401); 
    echo json_encode(['error' => 'Credenciales incorrectas']);
    exit;
}
$sql_grupo = "SELECT grupo_id FROM usuario_grupo WHERE usuario_id = ?";
$stmt_grupo = $conexion->prepare($sql_grupo);
$stmt_grupo->bind_param("i", $usuario_id);
$stmt_grupo->execute();
$stmt_grupo->bind_result($grupo_id);
$stmt_grupo->fetch();
$stmt_grupo->close();

if (!$grupo_id) {
    echo json_encode(['error' => 'El usuario no pertenece a ningún grupo']);
    exit;
}
$tipo_codigo = $_POST['tipo_codigo'];
$codigo = trim($_POST['codigo']); 
$fechahora = date('Y-m-d H:i:s'); 
if (!empty($codigo)) {
    $sql_insert = "INSERT INTO codigousuario (usuario_id, grupo_id, tipo_codigo, codigo, fechahora) VALUES (?, ?, ?, ?, ?)
                   ON DUPLICATE KEY UPDATE codigo = VALUES(codigo), fechahora = VALUES(fechahora)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("iisss", $usuario_id, $grupo_id, $tipo_codigo, $codigo, $fechahora);

    if ($stmt_insert->execute()) {
    } else {
        echo json_encode(['error' => 'Error al guardar el código']);
    }
    $stmt_insert->close();
} else {
}
?>
