<?php
session_start();
include_once "../config.php";

// Consulta SQL para seleccionar todos los usuarios registrados
$sql = "SELECT * FROM usuarios";
$query = mysqli_query($conn, $sql);
$output = "";

// Verificar si hay usuarios registrados
if (mysqli_num_rows($query) > 0) {
    // Iterar a través de los resultados y construir la salida
    while ($row = mysqli_fetch_assoc($query)) {
        $output .= '<div class="user">
                        <a href="../../client/chat.php?user_id=' . $row['id'] . '" class="username">' . htmlspecialchars($row['nombre_usuario']) . '</a>
                    </div>';
    }
} else {
    $output .= "No hay usuarios registrados en la base de datos.";
}

echo $output;
?>