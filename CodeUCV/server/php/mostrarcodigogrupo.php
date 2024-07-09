<?php
session_start();
require_once("conexion_be.php");

// Verificar si hay una sesión activa
if (!isset($_SESSION['nombre_usuario'])) {
    http_response_code(401); // Unauthorized
    exit('No autorizado. Por favor inicia sesión.');
}

// Verificar si se recibió un tipo de código válido
if (!isset($_GET['tipo_codigo'])) {
    http_response_code(400); // Bad Request
    echo 'Tipo de código no especificado';
    exit;
}

$tipo_codigo = $_GET['tipo_codigo'];

// Obtener nombre de usuario de la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];

// Obtener usuario_id de la base de datos según nombre de usuario
$sql_usuario = "SELECT id FROM usuarios WHERE nombre_usuario = ?";
$stmt_usuario = $conexion->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $nombre_usuario);
$stmt_usuario->execute();
$stmt_usuario->bind_result($usuario_id);
$stmt_usuario->fetch();
$stmt_usuario->close();

if (!$usuario_id) {
    http_response_code(401); // Unauthorized
    echo 'Credenciales incorrectas';
    exit;
}

// Obtener grupo_id del usuario
$sql_grupo = "SELECT grupo_id FROM usuario_grupo WHERE usuario_id = ?";
$stmt_grupo = $conexion->prepare($sql_grupo);
$stmt_grupo->bind_param("i", $usuario_id);
$stmt_grupo->execute();
$stmt_grupo->bind_result($grupo_id);
$stmt_grupo->fetch();
$stmt_grupo->close();

if (!$grupo_id) {
    echo 'Empieza a practicar';
    exit;
}

// Obtener código según usuario_id, grupo_id y tipo_codigo
$sql_codigo = "SELECT codigo FROM codigousuario WHERE grupo_id = ? AND tipo_codigo = ?  ORDER BY fechahora DESC
               LIMIT 1";
$stmt_codigo = $conexion->prepare($sql_codigo);
$stmt_codigo->bind_param("is", $grupo_id, $tipo_codigo);
$stmt_codigo->execute();
$stmt_codigo->bind_result($codigo);
$stmt_codigo->fetch();
$stmt_codigo->close();

if (!isset($codigo)) {
    $codigo = ""; // Asignar una cadena vacía si no se encuentra el código
}

echo $codigo;
?>
