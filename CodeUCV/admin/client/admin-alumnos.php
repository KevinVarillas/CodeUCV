<?php
include '../server/conexion.php';
// Verificar la conexión y ejecutar la consulta SQL

if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total_posts FROM posts";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $total_posts = $row['total_posts'];
} else {
    // Manejar el error si la consulta no fue exitosa
    echo "Error al ejecutar la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>

<?php
// Incluir el archivo de conexión a la base de datos
include '../server/conexion.php';

// Consulta SQL para contar usuarios registrados
$sql = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
$result = $conn->query($sql);

// Inicializar la variable para almacenar el número total de usuarios
$total_usuarios = 0;

// Verificar si se obtuvo algún resultado
if ($result) {
    // Obtener el resultado como un array asociativo
    $row = $result->fetch_assoc();
    // Asignar el número total de usuarios a la variable
    $total_usuarios = $row['total_usuarios'];
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<?php
// Incluir el archivo de conexión a la base de datos
include '../server/conexion.php';

// Consulta SQL para contar comentarios
$sql_comentarios = "SELECT COUNT(*) AS total_comentarios FROM comentarios";
$result_comentarios = $conn->query($sql_comentarios);

// Inicializar la variable para almacenar el número total de comentarios
$total_comentarios = 0;

// Verificar si se obtuvo algún resultado
if ($result_comentarios) {
    // Obtener el resultado como un array asociativo
    $row_comentarios = $result_comentarios->fetch_assoc();
    // Asignar el número total de comentarios a la variable
    $total_comentarios = $row_comentarios['total_comentarios'];
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<?php
include '../server/conexion.php';
// Consulta SQL para contar hombres y mujeres
$sql = "SELECT genero, COUNT(*) as cantidad FROM usuarios GROUP BY genero";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [$row['genero'], (int) $row['cantidad']];
    }
} else {
    echo "0 resultados";
}
$conn->close();
?>

<?php
include '../server/conexion.php';
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>





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
                    <input type="text" class="form-control" placeholder="Busca aquí">
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
                            <span class="notification-title">Notificaticiones</span>
                            <a href="javascript:void(0)" class="clear-noti"> Limpiar Todo </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="../client/img/profiles/avatar-02.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Ana lucia</span> has
                                                    approved <span class="noti-title">your estimate</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="../client/img/profiles/avatar-11.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">International Software
                                                        Inc</span> has sent you a invoice in the amount of <span
                                                        class="noti-title">$218</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="../client/img/profiles/avatar-17.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">John Hendry</span> sent
                                                    a cancellation request <span class="noti-title">Apple iPhone
                                                        XR</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img class="avatar-img rounded-circle" alt="User Image"
                                                    src="../client/img/profiles/avatar-13.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details"><span class="noti-title">Mercury Software
                                                        Inc</span> added a new product <span class="noti-title">Apple
                                                        MacBook Pro</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="#"> Ver todas las notificaciones</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item zoom-screen me-2">
                    <a href="#" class="nav-link header-nav-list win-maximize">
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

                            <div class="user-text">
                                <h6>Code UCV</h6>
                                <p class="text-muted mb-0">Administrator</p>
                            </div>
                        </div>
                        <!-- <a class="dropdown-item" href="profile.php">Mi perfil</a>
                        <a class="dropdown-item" href="inbox.php">Bandeja de entrada</a> -->
                        <a class="dropdown-item" href="../../client/paginaprincipal/pagina.php">Cerrar sesión</a>
                    </div>
                </li>

            </ul>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <!--<li class="menu-title">
                            <span>Menu Principal</span>
                        </li>-->
                        <li class="submenu active">
                            <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="admin-alumnos.php" class="active">Administrador Alumnos</a></li>
                                <li><a href="admin-comentarios.php">Administrador Comentarios</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Reportes</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="reportealumno.php">Reportes Alumnos</a></li>
                                <li><a href="reportecomentario.php">Reportes Comentarios</a></li>

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
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Buen dia, Administrador</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin-alumnos.php">Principal</a></li>
                                    <li class="breadcrumb-item active">Administrador</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Estudiantes</h6>
                                        <h3><?php echo $total_usuarios; ?></h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../client/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Proyectos</h6>
                                        <h3><?php echo isset($total_posts) ? $total_posts : '0'; ?></h3>
                                    </div>

                                    <div class="db-icon">
                                        <img src="../client/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Comentarios</h6>
                                        <h3><?php echo $total_comentarios; ?></h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../client/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-6">

                        <div class="card card-chart">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title">Descripción general</h5>
                                    </div>
                                    <div class="col-6">
                                        <ul class="chart-list-out">

                                            <li><span class="circle-green"></span>Estudiantes</li>
                                            <li class="star-menus"><a href="javascript:;"><i
                                                        class="fas fa-ellipsis-v"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div id="apexcharts-area" style="width: 100%; height: 400px;"></div>
                            </div>

                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                            <script type="text/javascript">
                                google.charts.load('current', { 'packages': ['corechart'] });
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {
                                    // Datos del gráfico
                                    var data = google.visualization.arrayToDataTable([
                                        ['año', 'Students'],
                                        ['2024', <?php echo $total_usuarios; ?>],
                                    ]);

                                    // Opciones del gráfico
                                    var options = {
                                        title: 'Número de estudiantes',
                                        legend: { position: 'none' },
                                        hAxis: { title: 'Año', titleTextStyle: { color: '#333' } },
                                        vAxis: { minValue: 0 },
                                        colors: ['#b80bc8']  // Cambiar el color del gráfico aquí
                                    };

                                    // Crear un nuevo gráfico de barras
                                    var chart = new google.visualization.ColumnChart(document.getElementById('apexcharts-area'));
                                    chart.draw(data, options);
                                }
                            </script>


                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">

                        <div class="card card-chart">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title">Numero de estudiantes</h5>
                                    </div>
                                    <div class="col-6">
                                        <ul class="chart-list-out">
                                            <li><span class="circle-blue"></span>Mujeres</li>
                                            <li><span class="circle-green"></span>Hombre</li>
                                            <li class="star-menus"><a href="javascript:;"><i
                                                        class="fas fa-ellipsis-v"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="bar"></div>
                            </div>
                            <html>

                            <head>
                                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                <script type="text/javascript">
                                    google.charts.load('current', { 'packages': ['corechart'] });
                                    google.charts.setOnLoadCallback(drawChart);

                                    function drawChart() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['Género', 'Cantidad'],
                                            <?php
                                            foreach ($data as $row) {
                                                echo "['" . $row[0] . "', " . $row[1] . "],";
                                            }
                                            ?>
                                        ]);

                                        var options = {
                                            is3D: true,
                                            colors: ['#b80bc8', '#0ab39c'],  // Colores asignados: mujeres y hombres
                                            legend: { position: 'bottom', textStyle: { color: '#333', fontSize: 12 } },
                                            backgroundColor: 'none',  // Fondo transparente
                                            chartArea: { left: 50, top: 50, width: '80%', height: '70%' }
                                        };

                                        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                                        chart.draw(data, options);
                                    }
                                </script>
                            </head>

                            <body>
                                <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
                            </body>

                            </html>


                        </div>


                    </div>
                    <?php


                    // Verificar la conexión
                    if ($conn->connect_error) {
                        die("La conexión ha fallado: " . $conn->connect_error);
                    }

                    // Consulta SQL para obtener la cantidad de posts por usuario
                    $sql = "SELECT usuario, COUNT(*) as cantidad_posts FROM posts GROUP BY usuario";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        ?>
                        <div class="row">
                            <div class="col-xl-6 d-flex">
                                <div class="card flex-fill student-space comman-shadow">
                                    <div class="card-header d-flex align-items-center">
                                        <h5 class="card-title">Estudiantes Tops </h5>
                                        <ul class="chart-list-out student-ellips">
                                            <li class="star-menus"><a href="javascript:;"><i
                                                        class="fas fa-ellipsis-v"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table
                                                class="table star-student table-hover table-center table-borderless table-striped">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre Usuario</th>
                                                        <th class="text-center">Cantidad</th>
                                                        <th class="text-center">Porcentaje</th>
                                                        <th class="text-end">Año</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = $result->fetch_assoc()) {
                                                        // Obtener el total de posts
                                                        $total_posts = obtenerTotalPosts($conn);

                                                        // Calcular el porcentaje
                                                        $porcentaje = ($row['cantidad_posts'] / $total_posts) * 100;
                                                        ?>
                                                        <tr>
                                                            <td class="text-nowrap">
                                                                <div><?php echo htmlspecialchars($row['usuario']); ?></div>
                                                            </td>
                                                            <td class="text-nowrap"><a href="profile.php">
                                                                    <?php echo htmlspecialchars($row['usuario']); ?></a></td>
                                                            <td class="text-center">
                                                                <?php echo htmlspecialchars($row['cantidad_posts']); ?></td>
                                                            <td class="text-center">
                                                                <?php echo number_format($porcentaje, 2) . '%'; ?></td>
                                                            <td class="text-end">
                                                                <div><?php echo date('Y'); ?></div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "No se encontraron datos.";
                    }

                    // Función para obtener el total de posts
                    function obtenerTotalPosts($conn)
                    {
                        $sql_total = "SELECT COUNT(*) as total FROM posts";
                        $result_total = $conn->query($sql_total);
                        $row_total = $result_total->fetch_assoc();
                        return $row_total['total'];
                    }

                    $conn->close();
                    ?>

                    <footer>
                        <p>CodeUCV 2024</p>
                    </footer>
                </div>
            </div>

            <script src="../client/js/jquery-3.6.0.min.js"></script>
            <script src="../client/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="../client/js/feather.min.js"></script>
            <script src="../client/plugins/slimscroll/jquery.slimscroll.min.js"></script>
            <script src="../client/plugins/apexchart/chart-data.js"></script>
            <script src="../client/js/script.js"></script>
</body>

</html>