<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../iniciosesion/iniciosesion.php");
    exit;
}

// Incluir el archivo de conexión a la base de datos
include '../../server/php/conexion_be.php';

// Obtener el correo del usuario desde la sesión
$correo = $_SESSION['usuario'];

// Consultar la base de datos para obtener nombre, apellido y otros datos del usuario
$sql = "SELECT nombre, apellido, genero, fecha_nacimiento, habilidades, imagen_perfil FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows > 0) {
    // Obtener los datos del usuario
    $usuario = $resultado->fetch_assoc();
    $nombre = $usuario['nombre'];
    $apellido = $usuario['apellido'];
    $genero = $usuario['genero'];
    $fecha_nacimiento = $usuario['fecha_nacimiento'];
    $habilidades = $usuario['habilidades'];
    $imagen_perfil = $usuario['imagen_perfil'];
} else {
    $nombre = '';
    $apellido = '';
    $genero = '';
    $fecha_nacimiento = '';
    $habilidades = '';
    $imagen_perfil = './img/niño.jpg'; 
}

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <section class="seccion-perfil-usuario">
        <div class="perfil-usuario-header">
            <div class="perfil-usuario-portada">
                <div class="perfil-usuario-avatar" id="avatar-container">
                    <?php
                    // Mostrar imagen de perfil
                    if (!empty($imagen_perfil)) {
                        echo '<img id="avatar-img" src="data:image/jpeg;base64,' . base64_encode($imagen_perfil) . '" alt="img-avatar">';
                    } else {
                        echo '<img id="avatar-img" src="http://localhost/multimedia/relleno/img-c9.png" alt="">';
                    }
                    ?>
                    <button type="button" class="boton-avatar" id="avatar-btn">
                        <i class="far fa-image"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="perfil-usuario-body">
            <div class="perfil-usuario-bio">
                <div id="nombre-container">
                    <p class="nombre-completo"><?php echo $nombre . ' ' . $apellido; ?></p>
                    <h3 class="usuario" id="nombre-usuario"><?php echo $_SESSION['nombre_usuario']; ?></h3>

                </div>
                <p class="correo"><?php echo $correo; ?></p>
            </div>
            <form id="perfil-form" method="POST" action="../../server/php/actualizar_perfil.php" enctype="multipart/form-data">
                <input type="hidden" name="correo" value="<?php echo $correo; ?>">
                <input type="file" name="imagen_perfil" id="file-input" style="display: none;" accept="image/*">
                <div class="perfil-usuario-footer">
                    <ul class="lista-datos">
                        <li><i class="icono fas fa-user"></i> Nombre: <input type="text" name="nombre" class="input-dato" id="input-nombre" value="<?php echo $nombre; ?>"></li>
                        <li><i class="icono fas fa-user"></i> Apellido: <input type="text" name="apellido" class="input-dato" id="input-apellido" value="<?php echo $apellido; ?>"></li>
                        <li><i class="icono fas fa-venus-mars"></i> Género: <input type="text" name="genero" class="input-dato" id="input-genero" value="<?php echo $genero; ?>"></li>
                    </ul>
                    <ul class="lista-datos">
                        <li><i class="icono fas fa-calendar-alt"></i> Fecha de nacimiento: <input type="date" name="fecha_nacimiento" class="input-nacimiento" id="input-nacimiento" value="<?php echo $fecha_nacimiento; ?>"></li>
                        <li><i class="icono fas fa-tools"></i> Habilidades: <input type="text" name="habilidades" class="input-habi" id="input-habilidades" value="<?php echo $habilidades; ?>"></li>
                    </ul>
                    <button type="submit" class="boton-registrar" id="boton-registrar">Guardar</button>
                </div>
            </form>
        </div>
    </section>


    <script>
        document.getElementById('avatar-btn').addEventListener('click', function() {
            document.getElementById('file-input').click();
        });

        document.getElementById('file-input').addEventListener('change', function() {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('avatar-img').src = e.target.result;
            }

            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>
