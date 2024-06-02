<?php
session_start();
require_once '../../config/global.php';
require_once '../../config/db.php';
define('RUTA_INCLUDE', '../../'); //ajustar a necesidad
$matAlumno = isset($_SESSION['matricula']) ? $_SESSION['matricula'] : null;

if (!$matAlumno) {
    header('Location: ../index.php');
    exit();
}

//obtener datos del alumno
$sql_alumno = "SELECT a.nombre, a.semestre, p.estatus FROM alumnos a LEFT JOIN practicas p ON a.matricula = p.matricula_alumno WHERE a.matricula = '$matAlumno';";
$res = mysqli_query($conexion, $sql_alumno);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $nombre = $row['nombre'];
    $semestre = $row['semestre'];
    $practica_status = $row['estatus'];
} else {
    header('Location: ../index.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo PAGE_TITLE ?></title>


    <?php getTopIncludes(RUTA_INCLUDE ) ?>
</head>

<body id="page-top">

<?php getNavbar() ?>

<div id="wrapper">

    <?php getSidebarAlumno('./', $semestre, $practica_status) ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <h1>Hola, <?php echo $nombre?></h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Inicio</li>
                    <li class="breadcrumb-item"></li>
                </ol>
            </nav>

            <!-- Page Content -->
            <hr>
            <p>Utiliza esta página para crear tus pantallas.</p>

        </div>
        <!-- /.container-fluid -->

        <?php getFooter() ?>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php getModalLogout() ?>

<?php getBottomIncudes( RUTA_INCLUDE ) ?>
</body>

</html>
