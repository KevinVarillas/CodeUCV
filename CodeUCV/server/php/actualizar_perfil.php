<?php
session_start();
require_once("conexion_be.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    http_response_code(401); // Unauthorized
    exit('No autorizado. Por favor inicia sesión.');
}

// Obtener el correo del usuario desde la sesión
$correo = $_SESSION['usuario'];

// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405); // Method Not Allowed
    exit('Método no permitido');
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$genero = $_POST['genero'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$habilidades = $_POST['habilidades'];

// Verificar si se ha subido una nueva imagen
if (isset($_FILES['imagen_perfil']) && $_FILES['imagen_perfil']['error'] == 0) {
    $imagen_perfil = file_get_contents($_FILES['imagen_perfil']['tmp_name']);
} else {
    $imagen_perfil = null;
}

// Actualizar los datos del usuario en la base de datos
if ($imagen_perfil) {
    $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, genero = ?, fecha_nacimiento = ?, habilidades = ?, imagen_perfil = ? WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $apellido, $genero, $fecha_nacimiento, $habilidades, $imagen_perfil, $correo);
} else {
    $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, genero = ?, fecha_nacimiento = ?, habilidades = ? WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $apellido, $genero, $fecha_nacimiento, $habilidades, $correo);
}

if ($stmt->execute()) {
    // Redirigir de vuelta al perfil después de la actualización
    header("Location: ../../client/perfil/index.php");
    exit();
} else {
    echo "Error al actualizar el perfil: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
