<?php
session_start();
include 'conexion_be.php';

// Verificar sesión de usuario
if (!isset($_SESSION['usuario'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Por favor inicia sesión']);
    exit;
}

// Obtener ID del usuario actual
$nombre_usuario = $_SESSION['nombre_usuario'];
$sql_usuario_id = "SELECT id FROM usuarios WHERE nombre_usuario = ?";
$stmt_usuario_id = $conexion->prepare($sql_usuario_id);
$stmt_usuario_id->bind_param("s", $nombre_usuario);
$stmt_usuario_id->execute();
$stmt_usuario_id->bind_result($usuario_id);
$stmt_usuario_id->fetch();
$stmt_usuario_id->close();

if (!$usuario_id) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error al obtener información del usuario']);
    exit;
}

// Actualizar estado de sesión a "offline" en la tabla estadousuario
$update_estado = mysqli_query($conexion, "UPDATE estadousuario SET estado = 'offline' WHERE usuarioid = " . $usuario_id);

// Verificar si se actualizó correctamente
if ($update_estado) {
    // Limpiar variables de sesión
    $_SESSION = [];
    session_destroy();
    header("location: ../../client/iniciosesion/iniciosesion.php");
    exit;
} else {
    echo '
        <script>
            alert("Error al cerrar sesión");
            window.location = "../../client/principal.php";
        </script>
    ';
    exit;
}
?>
