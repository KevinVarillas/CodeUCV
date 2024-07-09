<?php
session_start();
include 'conexion_be.php';

// Verificar si los datos se están enviando correctamente
if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contrasena = $_POST['contrasena'];

    // Verificar credenciales de inicio de sesión
    $validar_login = mysqli_query($conexion, "SELECT * FROM administrador WHERE correo='$correo' AND activo = 1");

    if (mysqli_num_rows($validar_login) > 0) {
        $administrador = mysqli_fetch_assoc($validar_login);
        
        // Verificar la contraseña
        if ($administrador['contrasena'] == $contrasena) {
            $_SESSION['usuarioad'] = $correo;
            $_SESSION['nombre_ad'] = $administrador['nombre_ad'];

            if ($correo == 'administrador@ucvvirtual.edu.pe') {
                header("location: ../../admin/admin-alumnos.php");
                exit;
            } else {
                header("location: ../../client/principal.php");
                exit;
            }
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta";
            //header("location: ../login.php?error=1");
            exit;
        }
    } else {
        // Usuario no encontrado o inactivo
        echo "Usuario no encontrado o inactivo";
        //header("location: ../login.php?error=1");
        exit;
    }
} else {
    // Datos no enviados correctamente
    echo "Datos no enviados correctamente";
    //header("location: ../login.php?error=1");
    exit;
}
?>
