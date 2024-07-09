<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el ID del usuario a eliminar
    $id = intval($_POST['id']);

    // Consulta para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = ?";
    
    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            echo "Usuario eliminado con éxito.";
        } else {
            echo "Error al eliminar el usuario.";
        }
        
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
}

// Redirigir de vuelta a la página principal después de la eliminación
header("Location: reportealumno.php");
exit();
?>
