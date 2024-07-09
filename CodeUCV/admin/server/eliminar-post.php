<?php
// Verificar si se recibió un ID válido por GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $post_id = $_GET['id'];

    // Realizar la conexión a la base de datos (reutiliza tu lógica de conexión)
    include 'conexion.php'; // Asegúrate de incluir tu archivo de conexión

    // Preparar la consulta para eliminar el post
    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $post_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redireccionar de regreso a proyecto.php u otra página deseada después de eliminar
        header('Location: proyecto.php');
        exit;
    } else {
        // Manejar errores si la eliminación no fue exitosa
        echo "Error al intentar eliminar el post.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    // Manejar caso en que no se proporcionó un ID válido
    echo "ID de post no válido.";
}
