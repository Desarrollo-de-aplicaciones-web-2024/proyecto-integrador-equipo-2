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

    <style>
        .carousel-item {
            position: relative;
        }

        .carousel-item .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Overlay negro con 50% de opacidad */
            z-index: 1;
        }

        .carousel-item img {
            width: 100%;
            height: auto;
        }
    </style>

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

            <?php
            $sql_vacantes = "SELECT * FROM convocatorias WHERE visible = 1 ORDER BY id DESC LIMIT 5;;";
            $vacantes = mysqli_query($conexion, $sql_vacantes);

            if ($vacantes && mysqli_num_rows($vacantes) > 0) {
                $html = <<<HTML
    <div class="container d-flex justify-content-center">
        <div id="carouselExampleIndicators" class="carousel slide" style="width: 70%;" data-ride="carousel">
            <ol class="carousel-indicators">
HTML;

                $i = 0;
                while ($row = mysqli_fetch_assoc($vacantes)){
                    $activeClass = ($i === 0) ? 'active' : '';
                    $html .= <<<HTML
                <li data-target="#carouselExampleIndicators" data-slide-to="{$i}" class="{$activeClass}"></li>
HTML;
                    $i++;
                }

                $html .= <<<HTML
            </ol>
            <div class="carousel-inner">
HTML;

                mysqli_data_seek($vacantes, 0); // Reset the result pointer to the first row
                $i = 0;
                while ($row = mysqli_fetch_assoc($vacantes)){
                    $src = "../academia/Vinculador/vacantes/" . $row['imagen'];
                    $activeClass = ($i === 0) ? 'active' : '';
                    $vacantes_disponibles = $row['vacantes'] == 0 ? 'Indefinidas' : $row['vacantes'];
                    $html .= <<<HTML
                <div class="carousel-item {$activeClass}">
                    <div class="overlay"></div>
                    <img class="d-block w-100" src="{$src}" alt="Slide {$i}">
                    <div class="carousel-caption d-none d-md-block">
                    <h5><a href="alumno-convocatorias.php" style="color: white; text-decoration: none">{$row['titulo']}</a></h5>
                        
                        <p>Vacantes disponibles: {$vacantes_disponibles}</p>
                    </div>
                </div>
HTML;
                    $i++;
                }

                $html .= <<<HTML
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
HTML;

                echo $html;

            } else {
                echo 'No hay convocatorias en este momento';
            }
            ?>



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
