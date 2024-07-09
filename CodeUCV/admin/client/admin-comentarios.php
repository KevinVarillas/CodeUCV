<?php
// Incluir el archivo de conexión a la base de datos
include '../server/conexion.php';

// Consulta SQL para obtener datos de la tabla comentarios
$sql = "SELECT fecha, COUNT(id) AS total_comentarios FROM comentarios GROUP BY fecha ORDER BY fecha ASC";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Formato de fecha según el formato que uses en tu base de datos
        $fecha = $row['fecha'];
        // Formato numérico para el total de comentarios
        $total_comentarios = (int) $row['total_comentarios'];

        // Agregar datos al array en el formato que necesita Google Charts
        $data[] = array($fecha, $total_comentarios);
    }
}

// Convertir datos a formato JSON para pasarlo a JavaScript
$data_json = json_encode($data);
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

    <link rel="stylesheet" href="../client/plugins/simple-calendar/simple-calendar.css">

    <link rel="stylesheet" href="../client/css/style.css">
</head>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left">
                <a href="admin-alumnos.php" class="logo">
                <img src="../.././client/img/logo.png" alt="Logo">

                </a>
                <a href="admin-alumnos.php" class="logo logo-small">
                    <!--<img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">-->

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
                            <a href="javascript:void(0)" class="clear-noti"> Limpiar todo </a>
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
                                                <p class="noti-details"><span class="noti-title">Carlson Tech</span> has
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
                            <a href="#">Ver todas las notificaciones</a>
                        </div>
                    </div>
                </li>

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

                            <div class="user-text">
                                <h6>CodeUCV</h6>
                                <p class="text-muted mb-0">Administrator</p>
                            </div>
                        </div>
                        <!-- <a class="dropdown-item" href="profile.php">My Profile</a>
<a class="dropdown-item" href="inbox.php">Inbox</a> -->
                        <a class="dropdown-item" href="../../client/paginaprincipal/pagina.php">Cerrar sesión</a>
                    </div>
                </li>

            </ul>

        </div>


        <div class=" sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>

                        <li class="submenu active">
                            <a href="#"><i class="feather-grid"></i> <span> Dashboard</span> <span
                                    class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="admin-alumnos.php">Administrador de Alumnos</a></li>
                                <li><a href="admin-comentarios.php" class="active">Administrador de
                                        Comentarios</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span>
                                    Reportes</span> <span class="menu-arrow"></span></a>
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
                                    <li class="breadcrumb-item"><a href="admin-alumnos.php">Principal</a>
                                    </li>
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
                                        <h6>Comentarios</h6>
                                        <h3><?php echo $total_comentarios; ?></h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../client/img/icons/teacher-icon-01.svg" alt="Dashboard Icon">
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
                                        <h6>Respuestas</h6>
                                        <h3>4</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../client/img/icons/teacher-icon-02.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!DOCTYPE html>
                    <html lang="es">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Dashboard con Gráfico de Comentarios</title>
                        <!-- Bootstrap CSS -->
                        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
                            rel="stylesheet">
                        <!-- Font Awesome para iconos -->
                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
                        <!-- Estilos personalizados -->
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f8f9fa;
                            }

                            .card {
                                border-radius: 10px;
                                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            }

                            .card-header {
                                background-color: #f8f9fa;
                                border-bottom: none;
                            }

                            .card-title {
                                color: #007bff;
                                font-weight: bold;
                                margin-bottom: 0;
                            }

                            .chart-list-out {
                                list-style-type: none;
                                padding: 0;
                                display: flex;
                                justify-content: flex-end;
                                margin-bottom: 0;
                            }

                            .chart-list-out li {
                                margin-right: 15px;
                                color: #6c757d;
                                font-size: 14px;
                            }

                            .circle-blue {
                                display: inline-block;
                                width: 12px;
                                height: 12px;
                                background-color: #b80bc8;
                                border-radius: 50%;
                                margin-right: 5px;
                            }

                            .chart-container {
                                padding: 20px;
                                background-color: #ffffff;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <h5 class="card-title">Actividad de Comentarios</h5>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <ul class="chart-list-out">
                                                        <li><span class="circle-blue"></span>Comentarios
                                                        </li>
                                                        <li class="star-menus"><a href="javascript:;"><i
                                                                    class="fas fa-ellipsis-v"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body chart-container">
                                            <!-- Gráfico de Google Charts -->
                                            <div id="chart_div" style="height: 400px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Google Charts API -->
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', { 'packages': ['corechart'] });
                            google.charts.setOnLoadCallback(drawVisualization);

                            function drawVisualization() {
                                // Convertir datos JSON PHP a JavaScript
                                var jsonData = <?php echo $data_json; ?>;

                                // Crear un DataTable de Google Charts
                                var data = new google.visualization.DataTable();
                                data.addColumn('string', 'Fecha');
                                data.addColumn('number', 'Total Comentarios');

                                // Agregar datos al DataTable
                                jsonData.forEach(function (row) {
                                    data.addRow([row[0], row[1]]);
                                });

                                // Opciones del gráfico
                                var options = {
                                    title: 'Actividad de Comentarios por Fecha',
                                    vAxis: {
                                        title: 'Número de Comentarios',
                                        format: '0' // Formato de números en el eje vertical
                                    },
                                    hAxis: { title: 'Fecha' },
                                    seriesType: 'bars',
                                    series: { 1: { type: 'line', color: '#28a745' } }, // Color de la línea de comentarios
                                    colors: ['#b80bc8'], // Color de las barras
                                    legend: { position: 'top', alignment: 'center' }, // Leyenda arriba y centrada
                                    chartArea: { width: '70%', height: '70%' }, // Área del gráfico
                                    backgroundColor: '#f8f9fa' // Color de fondo
                                };

                                // Dibujar el gráfico ComboChart dentro del elemento con id 'chart_div'
                                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                                chart.draw(data, options);
                            }
                        </script>
                    </body>

                    </html>


                    <footer>
                        <p>Code UCV 2024</p>
                    </footer>

                </div>

            </div>


            <script src="../client/js/jquery-3.6.0.min.js"></script>

            <script src="../client/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

            <script src="../client/js/feather.min.js"></script>

            <script src="../client/plugins/slimscroll/jquery.slimscroll.min.js"></script>

            <script src="../client/plugins/apexchart/apexcharts.min.js"></script>
            <script src="../client/plugins/apexchart/chart-data.js"></script>

            <script src="../client/plugins/simple-calendar/jquery.simple-calendar.js"></script>
            <script src="../client/js/calander.js"></script>

            <script src="../client/js/circle-progress.min.js"></script>

            <script src="../client/js/script.js"></script>
</body>

</html>