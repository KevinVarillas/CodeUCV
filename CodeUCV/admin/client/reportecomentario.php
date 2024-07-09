<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Administrador</title>

    <!--<link rel="shortcut icon" href="assets/img/favicon.png">-->

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../client/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../client/plugins/feather/feather.css">
    <link rel="stylesheet" href="../client/plugins/icons/flags/flags.css">
    <link rel="stylesheet" href="../client/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../client/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../client/plugins/datatables/datatables.min.css">
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




                <li class="nav-item zoom-screen me-2">
                    <a href="#" class="nav-link header-nav-list">
                        <img src="../client/img/icons/header-icon-04.svg" alt="">
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
                        
                        <a class="dropdown-item" href="../../client/paginaprincipal/pagina.php">Cerrar sesión</a>
                    </div>
                </li>

            </ul>

        </div>


        <div class=" sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="submenu">
                            <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="admin-alumnos.php">Administrados Alumno</a></li>
                                <li><a href="admin-comentarios.php">Administrador Comentario</a></li>
                            </ul>
                        </li>
                        <li class="submenu active">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span>
                                    Reportes</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="reportealumno.php">Reportes Alumnos</a></li>
                                <li><a href="reportecomentario.php" class="active">Reporte Comentarios
                                    </a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="fa fa-newspaper"></i> <span> Proyectos</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="proyecto.php">Todos los Proyectos</a></li>

                            </ul>
                        </li>

                </div>
            </div>
        </div>


        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Lista de Comentarios</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin-alumnos.php">Menú-Comentarios</a>
                                </li>
                                <li class="breadcrumb-item active">Reportes</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-body">

                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">Comentarios</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="../server/generar_pdfC.php?source=comentarios"
                                                class="btn btn-outline-primary me-2"><i class="fas fa-download"></i>
                                                Descargar</a>
                                        </div>

                                        <?php
                                        // Incluir el archivo de conexión a la base de datos
                                        include '../server/conexion.php';
                                        ?>

                                        <div class="table-responsive">
                                            <table
                                                class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                                <thead class="student-thread">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>Comentario</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Consulta a la tabla comentarios
                                                    $sql = "SELECT id, nombre_usuario, comentarios FROM comentarios";
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        // Mostrar datos de cada fila
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                                            echo '<td>
                                                            <h2 class="table-avatar">
                                                            <a>' . htmlspecialchars($row["nombre_usuario"]) . '</a>
                                                            </h2>
                                                            </td>';
                                                            echo "<td>" . htmlspecialchars($row["comentarios"]) . "</td>";
                                                            echo '<td>
                                                            <form method="post" action="eliminar_comentario.php" onsubmit="return confirm(\'¿Estás seguro de que deseas eliminar este comentario?\');">
                                                            <input type="hidden" name="id" value="' . htmlspecialchars($row["id"]) . '">
                                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                            </form>
                                                            </td>';
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='4'>No hay comentarios</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>


                                        <footer>
                                            <p>CodeUCV 2024
                                            <p>
                                        </footer>

                                    </div>

                                </div>


                                <script src="../client/js/jquery-3.6.0.min.js"></script>

                                <script src="../client/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

                                <script src="../client/js/feather.min.js"></script>

                                <script src="../client/plugins/slimscroll/jquery.slimscroll.min.js"></script>

                                <script src="../client/plugins/datatables/datatables.min.js"></script>

                                <script src="../client/js/script.js"></script>
</body>

</html>