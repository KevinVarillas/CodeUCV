<?php

include 'conexion_be.php';

$nombre_usuario = $_POST['nombre_usuario'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];


$query = "INSERT INTO usuarios (nombre_usuario, correo, contrasena, nombre, apellido) 
            VALUES ('$nombre_usuario', '$correo', '$contrasena', '$nombre', '$apellido')";

$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");

if(mysqli_num_rows($verificar_correo) > 0){
    echo '
        <script>
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location.href = "../../cliente/iniciosesion/iniciosesion.php";
        </script>
    ';
    exit();
}

$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario' ");

if(mysqli_num_rows($verificar_usuario) > 0){
    echo '
        <script>
            alert("Este usuario ya está registrado, intenta con otro diferente");
            window.location.href = "../../cliente/iniciosesion/iniciosesion.php";
        </script>
    ';
    exit();
}

$ejecutar = mysqli_query($conexion, $query);

if($ejecutar){
    echo '
        <script>
            alert("Usuario almacenado correctamente");
            window.location.href = "../../cliente/iniciosesion/iniciosesion.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Inténtalo de nuevo, usuario no almacenado");
            window.location.href = "../../cliente/iniciosesion/iniciosesion.php";
        </script>
    ';
}

mysqli_close($conexion);

?>
