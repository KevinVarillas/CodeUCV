<?php
require_once("conexion_be.php");

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id) {
        session_start();
        $current_user = $_SESSION['nombre_usuario'];

        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $current_user);
        $stmt->execute();
        $stmt->bind_result($current_user_id);
        $stmt->fetch();
        $stmt->close();

        $stmt = $conexion->prepare("SELECT grupo_id FROM usuario_grupo WHERE usuario_id = ?");
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $stmt->bind_result($existing_group_id);
        $stmt->fetch();
        $stmt->close();

        if (!$existing_group_id) {
            $stmt = $conexion->prepare("INSERT INTO grupo (nombre) VALUES (?)");
            $group_name = "Grupo de " . $current_user;
            $stmt->bind_param("s", $group_name);
            $stmt->execute();
            $new_group_id = $stmt->insert_id;
            $stmt->close();
            $stmt = $conexion->prepare("INSERT INTO usuario_grupo (usuario_id, grupo_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $current_user_id, $new_group_id);
            $stmt->execute();
            $stmt->close();
        } else {
            $new_group_id = $existing_group_id;
        }
        $stmt = $conexion->prepare("INSERT INTO usuario_grupo (usuario_id, grupo_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $new_group_id);

        if ($stmt->execute()) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false, 'message' => 'Error al agregar el usuario al grupo.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['exists' => false, 'message' => 'El usuario no existe.']);
    }

    $conexion->close();
} else {
    echo json_encode(['exists' => false, 'message' => 'Datos incompletos proporcionados.']);
}
?>
