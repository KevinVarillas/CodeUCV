<?php
include '../server/conexion.php';
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);

// Cerrar conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Administrador</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../client/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../client/plugins/feather/feather.css">
    <link rel="stylesheet" href="../client/plugins/icons/flags/flags.css">
    <link rel="stylesheet" href="../client/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../client/css/feather.css">
    <link rel="stylesheet" href="../client/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../client/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../client/css/style.css">
</head>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left">
                <a href="admin-alumnos.php" class="logo">
                <img src="../.././client/img/logo.png" alt="Logo">
                </a>
            </div>

            <div class="menu-toggle">
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fas fa-bars"></i>
                </a>
            </div>

            <div class="top-nav-search">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>

            <ul class="nav user-menu">
                <li class="nav-item dropdown noti-dropdown me-2">

                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notificaciones</span>
                            <a href="javascript:void(0)" class="clear-noti"> Limpiar Todo </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">

                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Ana Lucia</span> has
                                                    approved <span class="noti-title">your estimate</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="#">View all Notifications</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item zoom-screen me-2">
                    <a href="#" class="nav-link header-nav-list">
                        <img src="./img/icons/header-icon-04.svg" alt="">
                    </a>
                </li>

                <li class="nav-item dropdown has-arrow new-user-menus">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <div class="user-text">
                                <h6>CodeUCV</h6>
                                <p class="text-muted mb-0">Administrator</p>
                            </div>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                            </div>
                            <div class="user-text">
                                <h6>CodeUCV</h6>
                                <p class="text-muted mb-0">Administrator</p>
                            </div>
                        </div>
                        <!-- <a class="dropdown-item" href="profile.php">MI Perfil</a>
<a class="dropdown-item" href="inbox.php">Inbox</a> -->
                        <a class="dropdown-item" href="../../client/paginaprincipal/pagina.php">Cerrar sesión</a>
                    </div>
                </li>

            </ul>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="submenu">
                            <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="admin-alumnos.php">Administrador Alumnos</a></li>
                                <li><a href="admin-comentarios.php">Administrador Comentarios</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Reportes</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="reportealumno.php">Reporte Alumnos</a></li>
                                <li><a href="reportecomentario.php">Reportes Comentarios</a></li>

                            </ul>
                        </li>


                        <li class="submenu active">
                            <a href="#"><i class="fa fa-newspaper"></i> <span> Proyectos</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="proyecto.php" class="active">Todos los Proyectos</a></li>

                            </ul>
                        </li>


                </div>
            </div>
        </div>


        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="row">
                    <div class="col-md-9">
                        <ul class="list-links mb-4">
                            <li class="active"><a href="proyecto.php">Proyectos Activos</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 text-md-end">
                    </div>
                </div>
                <?php
                // Iterar sobre los resultados de la consulta SQL
                if ($result->num_rows > 0) {
                    // Ruta de la carpeta donde están las imágenes de portada
                    $ruta_directorio = '../.././server/subirarchivo/uploads/';

                    // Contador para las columnas en Bootstrap (12 columnas en total)
                    $columnas_por_fila = 3;
                    $contador_columnas = 0;
                    ?>
                    <div class="row">
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            // Mostrar la imagen de la portada
                            $imagen_portada = $ruta_directorio . $row['imagen_portada'];
                            ?>
                            <div class="col-md-4 mb-4">
                                <div class="blog grid-blog flex-fill">
                                    <div class="blog-image">
                                        <a href="#"><img class="img-fluid" src="<?php echo $imagen_portada; ?>"
                                                alt="Post Image"></a>
                                    </div>
                                    <div class="blog-content">
                                        <ul class="entry-meta meta-item">
                                            <li>
                                                <div class="post-author">
                                                    <a href="profile.php">
                                                        <span>
                                                            <span
                                                                class="post-title"><?php echo htmlspecialchars($row['usuario']); ?></span>
                                                            <span class="post-date"><i class="far fa-clock"></i>
                                                                <?php echo htmlspecialchars($row['fecha_publicacion']); ?></span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                        <h3 class="blog-title"><a
                                                href="blog-details.php"><?php echo htmlspecialchars($row['descripcion']); ?></a>
                                        </h3>
                                        <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                                    </div>
                                    <div class="row">
                                        <div class="edit-options">
                                            <div class="edit-delete-btn">
                                                <!-- Eliminar enlace de editar si no se necesita -->
                                                <!-- <a href="edit-proyecto.php?id=<?php echo $row['id']; ?>" class="text-success"><i class="feather-edit-3 me-1"></i> Editar</a> -->
                                                <a href="#" class="text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal_<?php echo $row['id']; ?>"><i
                                                        class="feather-trash-2 me-1"></i> Eliminar</a>
                                            </div>
                                            <div class="text-end inactive-style">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de Confirmación de Eliminación -->
                            <div class="modal fade" id="deleteModal_<?php echo $row['id']; ?>" tabindex="-1"
                                aria-labelledby="deleteModalLabel_<?php echo $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel_<?php echo $row['id']; ?>">Confirmar
                                                Eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar este post?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <a href="../server/eliminar-post.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-danger">Eliminar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            // Incrementar el contador de columnas
                            $contador_columnas++;

                            // Si el número de columnas alcanza el límite por fila, cierra la fila y comienza una nueva
                            if ($contador_columnas % $columnas_por_fila === 0) {
                                echo '</div><div class="row">';
                            }
                        }

                        // Cerrar la última fila si no se cierra automáticamente
                        if ($contador_columnas % $columnas_por_fila !== 0) {
                            echo '</div>';
                        }
                } else {
                    echo "No se encontraron posts.";
                }
                ?>



                    <div class="row ">
                        <div class="col-md-12">
                            <div class="pagination-tab  d-flex justify-content-center">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1"><i
                                                class="feather-chevron-left mr-2"></i>Anterior</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Siguiente<i
                                                class="feather-chevron-right ml-2"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="deleteModal" class="modal fade delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="form-content p-2">
                            <h4 class="modal-title">Eliminar</h4>
                            <p class="mb-4">¿Estás seguro de que deseas eliminar?</p>
                            <button type="button" class="btn btn-primary">Eliminar </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script src="./js/jquery-3.6.0.min.js"></script>
        <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="./plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="./plugins/select2/js/select2.min.js"></script>
        <script src="./js/script.js"></script>
</body>

</html>