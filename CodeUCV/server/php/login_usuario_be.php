<?php
session_start();
include 'conexion_be.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$validar_admin = mysqli_query($conexion, "SELECT * FROM administrador WHERE correo='$correo' AND contrasena='$contrasena' AND activo = 1");

if (mysqli_num_rows($validar_admin) > 0) {
    $administrador = mysqli_fetch_assoc($validar_admin);
    $_SESSION['usuarioad'] = $correo;
    $_SESSION['nombre_ad'] = $administrador['nombre_ad'];

    header("location: ../.././admin/client/admin-alumnos.php");
    exit;
}

// Verificar credenciales de inicio de sesión
$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena' AND activo = 1");

if (mysqli_num_rows($validar_login) > 0) {
    $usuario = mysqli_fetch_assoc($validar_login);
    $_SESSION['id'] = $usuario['id']; // Guarda también el ID del usuario en la sesión
    $_SESSION['usuario'] = $correo;
    $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];

    // Verificar si el usuario existe en la tabla estadousuario
    $usuario_id = $usuario['id'];
    $check_estado = mysqli_query($conexion, "SELECT * FROM estadousuario WHERE usuarioid = $usuario_id");
    
    if (mysqli_num_rows($check_estado) > 0) {
        // Actualizar estado de sesión a "online"
        $update_estado = mysqli_query($conexion, "UPDATE estadousuario SET estado = 'online' WHERE usuarioid = $usuario_id");
    } else {
        // Insertar nuevo estado de sesión como "online"
        $insert_estado = mysqli_query($conexion, "INSERT INTO estadousuario (usuarioid, estado) VALUES ($usuario_id, 'online')");
        $update_estado = $insert_estado; // Para mantener consistencia en el manejo de errores
    }

    // Verificar si se actualizó o insertó correctamente
    if ($update_estado) {
        header("Location: ../../client/principal.php");
        exit;
    } else {
        echo '
            <script>
                alert("Error al actualizar el estado de sesión: ' . mysqli_error($conexion) . '");
                window.location = "../../client/iniciosesion/iniciosesion.php";
            </script>
        ';
        exit;
    }
    } else {
        echo '
            <script>
                alert("Usuario no existe o contraseña incorrecta");
                window.location = "../../client/iniciosesion/iniciosesion.php";
            </script>
        ';
        exit;
    }
    ?>