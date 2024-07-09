<?php
include '../server/php/conexion_be.php'; // Asegúrate de que la ruta al archivo de conexión sea correcta

session_start();
if (!isset($_SESSION['id'])) {
    header("location: iniciosesion/iniciosesion.php");
    exit; // Asegurarse de que el script termine después de redirigir
}
if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Por favor debes de iniciar sesión");
            window.location = "iniciosesion/iniciosesion.php";
        </script>
    ';
    session_destroy();
    die();
}
// Verificar si la variable 'id' está configurada en la sesión
if (!isset($_SESSION['id'])) {
    // Si la variable 'id' no está configurada, redirigir a una página de error o manejar el error según tu aplicación
    echo '
        <script>
            alert("ID de usuario no encontrado. Por favor, inicia sesión de nuevo.");
            window.location = "iniciosesion/iniciosesion.php";
        </script>
    ';
    exit();
}

$id_usuario = isset($_SESSION['id']) ? $_SESSION['id'] : 'ID no encontrado';

$nombre_usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : 'Usuario';
$correo_usuario = $_SESSION['usuario'];
// Inicializar variables para nombre y apellido
$nombre = '';
$apellido = '';

// Consultar el nombre y apellido del usuario desde la base de datos
$consulta_usuario = mysqli_query($conexion, "SELECT nombre, apellido FROM usuarios WHERE correo='$correo_usuario'");

if ($consulta_usuario) {
    $usuario = mysqli_fetch_assoc($consulta_usuario);
    $nombre = $usuario['nombre'];
    $apellido = $usuario['apellido'];
} else {
    // Manejar el error de consulta si es necesario
}

// Inicializar variable para la imagen de perfil
$imagen_perfil = '';

// Consultar la imagen BLOB del usuario desde la base de datos
$consulta_usuario = mysqli_query($conexion, "SELECT imagen_perfil FROM usuarios WHERE correo='$correo_usuario'");

if ($consulta_usuario) {
    $usuario = mysqli_fetch_assoc($consulta_usuario);
    $imagen_perfil = $usuario['imagen_perfil'];
} else {
    // Manejar el error de consulta si es necesario
}

// Liberar el resultado
mysqli_free_result($consulta_usuario);

// Cerrar la conexión
mysqli_close($conexion);



$user_id = null;

// Si se ha proporcionado un user_id en la URL, procesar la solicitud
if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    // Consulta para obtener los detalles del usuario con el que se está chateando
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        header("location: users.php"); // Redireccionar si no se encuentra el usuario
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="principal.css">
    <link rel="stylesheet" href="proyecto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />


    <title>Code UCV</title>
</head>

<body>

    <nav>
        <div class="container">
            <div class="logoo">
                <img class="logo" src="./img/logo.png">

                <h2>CodeUCV</h2>
            </div>

            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" placeholder="Buscar proyectos, autores, inspiraciones">
            </div>
            <div class="create">
                <button class="btn btn-primary" for="create-post" onclick="loadContent('./perfil/index.php')">Mi
                    perfil</button>
                <div class="profile-photo">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen_perfil); ?>"
                        alt="Imagen de perfil">
                </div>
            </div>
        </div>
    </nav>
    <main>
        <div class="container">
            <div class="left">
                <a class="profile">
                    <div class="profile-photo">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen_perfil); ?>"
                            alt="Imagen de perfil">
                    </div>
                    <div class="handle">
                        <h4><?php echo htmlspecialchars($nombre . ' ' . $apellido, ENT_QUOTES, 'UTF-8'); ?></h4>
                        <p class="text-muted">
                            @<?php echo htmlspecialchars($nombre_usuario, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>
                </a>
                <div class="sidebar">
                    <a href="#" class="menu-item active" onclick="loadContent('dashboard')">
                        <span><i class="fa-solid fa-house"></i></span>
                        <h3>Principal</h3>
                    </a>
                    <a class="menu-item" id="notifications">
                        <span><i class="fa-solid fa-bell"><small class="notification-count">9+</small></i></span>
                        <h3>Notificaciones</h3>
                        <div class="notifications-popup">
                            <div>
                                <div class="profile-photo">
                                    <img src="./img/perfil2.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Josue Mendez</b> Empezó a seguirte.
                                    <small class="text-muted">Hace 2 minutos</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./img/perfil3.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Maria Julca</b> Le dió me gusta a tu proyecto.
                                    <small class="text-muted">Hace 4 minutos</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./img/perfil4.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Sherly Sosa</b> Le dió me gusta a tu proyecto.
                                    <small class="text-muted">Hace 5 minutos</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./img/perfil5.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Jhoana Rita</b> Comentó tu proyecto.
                                    <small class="text-muted">Hace 6 minutos</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./img/perfil6.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Juan Gonzales</b> Comentó tu proyecto.
                                    <small class="text-muted">Hace 7 minutos</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./img/perfil7.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Jhon Varillas</b> Comentó tu proyecto.
                                    <small class="text-muted">Hace 8 minutos</small>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="menu-item" id="message-notification">
                        <span><i class="fa-regular fa-envelope"><small class="notification-count">6</small></i></span>
                        <h3>Mensajes</h3>
                    </a>
                    <a class="menu-item" href="#" onclick="loadContent('./editor/index.php')">
                        <span><i class="fa-solid fa-code"></i></span>
                        <h3>Live Code Editor</h3>
                    </a>
                    <a class="menu-item" href="#" onclick="loadContent('./foro2/foro.php')">
                        <span><i class="fa-solid fa-comments"></i></i></span>
                        <h3>Foros</h3>
                    </a>
                    <a class="menu-item" id="mostrarTemas" href="#">
                        <span><i class="fa-solid fa-palette"></i></span>
                        <h3>Temas</h3>
                    </a>

                </div>
                <!------fin del sidebar-->
                <button class="btn btn-primary" onclick="location.href='../server/php/cerrarsesion.php'">Cerrar
                    Sesión</button>
            </div>

            <div id="default-content">
                <div class="middle">
                    <div class="stories">
                        <?php
                        // Incluir el archivo de conexión
                        include '../server/php/conexion_be.php';

                        // Consulta SQL para obtener las 3 publicaciones con más likes
                        $sql = "SELECT p.*, COUNT(l.id) AS like_count, u.imagen_perfil
            FROM posts p
            LEFT JOIN likes l ON p.id = l.post_id
            LEFT JOIN usuarios u ON p.usuario = u.nombre_usuario
            GROUP BY p.id
            ORDER BY like_count DESC
            LIMIT 3";

                        $result = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $positions = ['gold', 'silver', 'bronze']; // Clases para los lugares
                            $position_index = 0;

                            while ($row = mysqli_fetch_assoc($result)) {
                                $position_class = $positions[$position_index]; // Obtener la clase de posición
                                $position_index++; // Incrementar el índice para la siguiente publicación
                        
                                echo '<div class="story ' . $position_class . '">';

                                // Establecer el fondo de la historia basado en la imagen de portada
                                echo '<div class="background" style="background-image: url(\'../server/subirarchivo/uploads/' . $row['imagen_portada'] . '\');"></div>';

                                // Mostrar la foto de perfil del usuario
                                echo '<div class="profile-photo">';
                                if ($row['imagen_perfil']) {
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['imagen_perfil']) . '" alt="Foto de perfil">';
                                } else {
                                    echo '<img src="./img/niño.jpg" alt="Foto de perfil">';
                                }
                                echo '</div>';

                                // Mostrar el nombre de usuario
                                echo '<p class="name">' . htmlspecialchars($row['usuario'], ENT_QUOTES, 'UTF-8') . '</p>';
                                echo '</div>'; // Cierre de story
                            }
                        } else {
                            echo '<p>No hay historias para mostrar</p>';
                        }

                        // Cerrar la conexión a la base de datos
                        mysqli_close($conexion);
                        ?>
                    </div>




                    <div class="create-post-container">
                        <form class="create-post" id="formPrincipal">
                            <div class="profile-photo">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen_perfil); ?>"
                                    alt="Imagen de perfil">
                            </div>
                            <input type="text" placeholder="Publica tus proyectos" id="create-post">

                            <button type="button" id="btnAbrirModal" class="btn btn-primary">
                                <i class="fa-solid fa-upload"></i>Postear
                            </button>
                        </form>
                    </div>

                    <!-- The Modal -->
                    <div id="modal" class="modal hidden">
                        <div class="modal-content my-custom-modal">
                            <form id="formModal" action="../server/subirarchivo/subirproyecto.php" method="POST"
                                enctype="multipart/form-data">
                                <h1>Sube tu proyecto</h1>
                                <div class="header-section">
                                    <div class="nombrepro">
                                        <input type="text" name="descripcion" class="form-control-lg border-0"
                                            placeholder="Descripción del Proyecto" required>
                                    </div>
                                    <div class="upload-box">
                                        <input type="file" name="archivo_zip" id="projectFile" accept=".zip">
                                        <label for="projectFile" id="projectFileLabel">Haz clic para seleccionar archivo
                                            ZIP</label>
                                    </div>
                                    <button id="submitBtn" type="button">Visualizar Proyecto</button>
                                </div>
                                <div class="container">
                                    <div class="sidebar" id="sidebar">
                                        <!-- Las carpetas y archivos se generarán aquí -->
                                    </div>
                                    <div class="content" id="codeView"></div>
                                </div>
                                <div class="cover-section">
                                    <div class="cover-upload">
                                        <p>Sube una imagen o video de portada</p>
                                        <input type="file" name="imagen_portada" id="cover-upload"
                                            accept="image/*,video/*" class="input-file">
                                        <label for="cover-upload" class="cover-upload-label">Seleccionar imagen o
                                            video</label>
                                    </div>
                                    <div id="cover-preview" class="cover-preview"></div>
                                </div>
                                <input type="submit" value="Subir Proyecto" class="bton">
                            </form>
                        </div>
                    </div>

                    <div id="messageContainer" class="message-container"></div>


                    <!----FEEDS-->
                    <div id="feed" class="feeds">
                        <?php
                        // Incluir el archivo de conexión
                        include '../server/php/conexion_be.php';

                        $sql = "SELECT p.*, (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.id) AS like_count FROM posts p ORDER BY fecha_publicacion DESC, hora_publicacion DESC";
                        $result = mysqli_query($conexion, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Obtener la imagen de perfil del usuario que hizo la publicación
                                $sql_imagen = "SELECT imagen_perfil FROM usuarios WHERE nombre_usuario = ?";
                                $stmt_imagen = $conexion->prepare($sql_imagen);
                                $stmt_imagen->bind_param("s", $row['usuario']);
                                $stmt_imagen->execute();
                                $result_imagen = $stmt_imagen->get_result();

                                if ($result_imagen->num_rows > 0) {
                                    $row_imagen = $result_imagen->fetch_assoc();
                                    $imagen_perfil = $row_imagen['imagen_perfil'];
                                } else {
                                    $imagen_perfil = null;
                                }

                                // Verificar si el usuario ha dado like a la publicación
                                $sql_like = "SELECT * FROM likes WHERE usuario = ? AND post_id = ?";
                                $stmt_like = $conexion->prepare($sql_like);
                                $stmt_like->bind_param("si", $_SESSION['nombre_usuario'], $row['id']);
                                $stmt_like->execute();
                                $result_like = $stmt_like->get_result();
                                $user_liked = $result_like->num_rows > 0;
                                $stmt_like->close();

                                echo '<div class="feed">';
                                echo '<div class="feed-item">';

                                // Cabecera de la publicación (usuario, fecha, opciones)
                                echo '<div class="head">';
                                echo '<div class="user">';
                                echo '<div class="profile-photo">';
                                if ($imagen_perfil) {
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($imagen_perfil) . '" alt="Imagen de perfil">';
                                } else {
                                    echo '<img src="./img/niño.jpg" alt="Imagen de perfil">';
                                }
                                echo '</div>';
                                echo '<div class="info">';
                                echo '<h3>' . htmlspecialchars($row['usuario'], ENT_QUOTES, 'UTF-8') . '</h3>';
                                echo '<small>' . date('d/m/Y, H:i', strtotime($row['fecha_publicacion'] . ' ' . $row['hora_publicacion'])) . '</small>';
                                echo '</div>';
                                echo '</div>';

                                // Opciones de edición (visible según el usuario actual)
                                if ($row['usuario'] == $_SESSION['nombre_usuario']) {
                                    echo '<span class="edit"><i class="fa-solid fa-ellipsis"></i></span>';
                                    echo '<div class="opciones hidden">';
                                    echo '<ul>';
                                    echo '<li><a href="#" class="eliminar-publicacion" data-proyecto="' . $row['id'] . '">Eliminar</a></li>';
                                    echo '<li><button class="visualizar-codigo" data-proyecto="' . $row['id'] . '">Visualizar Código</button></li>';
                                    echo '<li><button class="descargar-codigo" data-proyecto="' . $row['id'] . '">Descargar Código</button></li>';
                                    echo '</ul>';
                                    echo '</div>';
                                } else {
                                    echo '<span class="edit"><i class="fa-solid fa-ellipsis"></i></span>';
                                    echo '<div class="opciones hidden">';
                                    echo '<ul>';
                                    echo '<li><button class="visualizar-codigo" data-proyecto="' . $row['id'] . '">Visualizar Código</button></li>';
                                    echo '<li><button class="descargar-codigo" data-proyecto="' . $row['id'] . '">Descargar Código</button></li>';
                                    echo '</ul>';
                                    echo '</div>';
                                }

                                echo '</div>'; // Cierre de head
                        
                                echo '<div class="modalcodigo hidden" data-proyecto="' . $row['id'] . '">';
                                echo '<div class="container">';
                                echo '<div class="sidebar" id="sidebar"></div>';
                                echo '<div class="content" id="codeView"></div>';
                                echo '</div>';
                                echo '</div>';

                                echo '<div class="photo">';
                                if (strpos($row['imagen_portada'], 'mp4') !== false) {
                                    echo '<video controls>';
                                    echo '<source src="../server/subirarchivo/uploads/' . $row['imagen_portada'] . '" type="video/mp4">';
                                    echo 'Tu navegador no soporta la etiqueta de video.';
                                    echo '</video>';
                                } else {
                                    echo '<img src="../server/subirarchivo/uploads/' . $row['imagen_portada'] . '">';
                                }
                                echo '</div>';

                                // Botones de acción (me gusta, compartir)
                                echo '<div class="action-button">';
                                echo '<div class="interaction-button">';
                                echo '<div class="action-button">';
                                echo '<span><i class="' . ($user_liked ? 'fa-solid' : 'fa-regular') . ' fa-heart like-icon" onclick="likeBtn(this)" data-proyecto="' . $row['id'] . '"></i></span>';
                                echo '<span class="like-count">' . $row['like_count'] . '</span>'; // Mostrar el conteo de likes
                                echo '<span><i class="fa-solid fa-bookmark save-icon save-btn" onclick="saveBtn(this)"></i></span>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';

                                // Descripción de la publicación
                                echo '<div class="caption">';
                                echo '<p><b>' . htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8') . '</b></p>';
                                echo '</div>';

                                echo '</div>'; // Cierre de feed-item
                                echo '</div>'; // Cierre de feed
                            }
                        } else {
                            echo '<p>No hay proyectos para mostrar</p>';
                        }
                        mysqli_close($conexion);
                        ?>
                    </div>
                </div>
            </div>
            <iframe id="contentFrame" name="contentFrame" src="" frameborder="0"
                style="width:840px; height:1000px; display: none;"></iframe>

            <div class="right">
                <div class="messages">
                    <div class="heading">
                        <h4>Chats</h4><i class="fa-solid fa-pen-to-square"></i></i>
                    </div>

                    <div class="category">
                        <h6 class="active">Principales</h6>
                    </div>
                    <iframe src="users.php" class="iframe-users" src="" frameborder="0"
                        style="width:18rem; height:40rem; margin-left:-3px;"></iframe>

                </div>


                <!----termina mensaje---->
            </div>

            <!----termina rigth---->
        </div>

    </main>
    <div id="customize-theme" class="customize-theme hidden">
        <div class="card">
            <h2>Personaliza a tu gusto</h2>
            <p class="text-muted">Elige el tamaño de letra, color, y el tema</p>
            <!--font size -->

            <div class="font-size">
                <h4>Tamaño de letra</h4>
                <div>
                    <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2 active"></span>
                        <span class="font-size-3"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                </div>
            </div>
            <!--color -->

            <div class="color">
                <h4>Color</h4>
                <div class="choose-color">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                    <span class="color-5"></span>
                </div>
            </div>

            <!--fondo -->

            <div class="background">
                <h4>Fondo</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Claro</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5>Dim</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Oscuro</h5>
                    </div>
                </div>
            </div>




        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js"></script>

    <script src="principal.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.5.0/jszip.min.js"></script>

    <script src="proyecto.js"></script>


</body>

</html>