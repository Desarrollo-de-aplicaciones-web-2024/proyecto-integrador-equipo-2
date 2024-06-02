<?php
session_start();
require '../../config/db.php';
require_once '../../config/global.php';
define('RUTA_INCLUDE', '../../'); //ajustar a necesidad

$matAlumno = isset($_SESSION['matricula']) ? $_SESSION['matricula'] : null;

if (!$matAlumno) {
    header('Location: ../index.php');
    exit();
}

//checar si esta en revision
$sql_revision = "select * from practicas WHERE matricula_alumno = '$matAlumno' AND estatus = 'revision'";
$res = mysqli_query($conexion, $sql_revision);
if ($res && mysqli_num_rows($res) > 0) {
    header('Location: mis-practicas.php');
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
    exit();
}

//ver si el alumno tiene una practica en estatus pendiente.
$sql_practica = "select * from practicas where matricula_alumno = $matAlumno and estatus = 'pendiente'";
$res = mysqli_query($conexion, $sql_practica);
if ($res) {
    if (mysqli_num_rows($res) > 0) { //solo deberia de haber 1 pratica pendiente
        while ($row = mysqli_fetch_assoc($res)) {
            $practica_id = $row['id'];
            $practica_matricula_alumno = $row['matricula_alumno'];
            $practica_estatus = $row['estatus'];
            $practica_id_empresa = $row['id_empresa'];
            $practica_duracion = $row['duracion'];
            $practica_nombre_supervisor = $row['supervisor'];
            $practica_puesto_supervisor = $row['puesto_supervisor'];
            $practica_fecha_inicio = $row['fecha_inicio'];
            $practica_fecha_fin = $row['fecha_fin'];
            $practica_puesto = $row['puesto'];
            $practica_departamento = $row['departamento'];
            $practica_horas = $row['horas'];
            $practica_horario_entrada = $row['horario_entrada'];
            $practica_horario_salida = $row['horario_salida'];
            $practica_id_carrera = $row['id_carrera'];
            $practica_actividades = $row['actividades'];

            //buscar si la practica tiene documentos cargados

        }
    } else {
        header("Location: inicio-practicas.php");
    }
}else {
    header("Location: inicio-practicas.php");
}

$status = isset($_SESSION['status']) ? $_SESSION['status'] : null;
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;

// Limpiar datos de sesión si ya no se necesitan
unset($_SESSION['fila_creada']);
unset($_SESSION['status']);
unset($_SESSION['mensaje']);

//precargar los archivos
$directory = "../servicio/inicial/";
$files = scandir($directory);

// Filtrar solo archivos PDF
$pdfFiles = array_filter($files, function($file) use ($directory) {
    return is_file($directory . $file) && pathinfo($file, PATHINFO_EXTENSION) == "pdf";
});

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var inputs = document.querySelectorAll('.custom-file-input');
            Array.prototype.forEach.call(inputs, function (input) {
                input.addEventListener('change', function (e) {
                    var fileName = input.files[0].name;
                    var label = document.getElementById(input.id+"-name");
                    label.innerHTML = fileName;
                });
            });
        });
    </script>


</head>

<body id="page-top">

<?php getNavbar() ?>

<div id="wrapper">

    <?php getSidebarAlumno('../alumnos/', $semestre, $practica_status); ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Page Content -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item active" aria-current="page">Documentación inicial</li>
                </ol>

                <?php

                switch ($status) {
                    case 'exito':
                        echo "
                            <div class='alert alert-success  alert-dismissible fade show' role= 'alert'>
                                <i class='fas fa-check'></i> $mensaje
                                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                            </div>";
                        break;
                    case 'error':
                        echo "
                            <div class='alert alert-danger  alert-dismissible fade show' role= 'alert'>
                                <i class='fas fa-exclamation-triangle'></i> $mensaje
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        break;
                    default:
                        break;
                }


                ?>
            </nav>

            <hr>
            <h2>Generación de documentos</h2>
            <hr>

            <div class='form-group col-md-5'>
                <div class='form-row justify-content-around'>
                    <div class='form-group col-md-6'>
                        <form target="_blank" action="generarPdf.php" method="post">

                            <input type="hidden" id="id-empresa" name="id-empresa" value="<?php echo $practica_id_empresa ?>"/>
                            <input type="hidden" id="matricula" name="matricula" value="<?php echo $practica_matricula_alumno ?>"/>
                            <input type="hidden" id="duracion" name="duracion" value="<?php echo $practica_duracion ?>"/>
                            <input type="hidden" id="puesto" name="puesto" value="<?php echo $practica_puesto ?>"/>
                            <input type="hidden" id="departamento" name="departamento" value="<?php echo $practica_departamento ?>"/>
                            <input type="hidden" id="horas" name="horas" value="<?php echo $practica_horas ?>"/>
                            <input type="hidden" id="fecha-inicio" name="fecha-inicio" value="<?php echo $practica_fecha_inicio ?>"/>
                            <input type="hidden" id="fecha-fin" name="fecha-fin" value="<?php echo $practica_fecha_fin ?>"/>
                            <input type="hidden" id="supervisor" name="supervisor" value="<?php echo $practica_nombre_supervisor ?>"/>
                            <input type="hidden" id="puesto-supervisor" name="puesto-supervisor" value="<?php echo $practica_puesto_supervisor ?>"/>
                            <input type="hidden" id="id-carrera" name="id-carrera" value="<?php echo $practica_id_carrera ?>"/>

                            <button type="submit" class="btn btn-outline-secondary">Solicitud de prácticas profesionales</button>
                        </form>
                    </div>

                    <div class='form-group col-md-6'>
                        <form target="_blank" action="plan-trabajo.php" method="post">
                            <input type="hidden" id="id-empresa" name="id-empresa" value="<?php echo $practica_id_empresa ?>"/>
                            <input type="hidden" id="matricula" name="matricula" value="<?php echo $practica_matricula_alumno ?>"/>
                            <input type="hidden" id="fecha-inicio" name="fecha-inicio" value="<?php echo $practica_fecha_inicio ?>"/>
                            <input type="hidden" id="horario-entrada" name="horario-entrada" value="<?php echo $practica_horario_entrada ?>"/>
                            <input type="hidden" id="horario-salida" name="horario-salida" value="<?php echo $practica_horario_salida ?>"/>
                            <input type="hidden" id="actividades" name="actividades" value="<?php echo $practica_actividades ?>"/>
                            <input type="hidden" id="supervisor" name="supervisor" value="<?php echo $practica_nombre_supervisor ?>"/>
                            <input type="hidden" id="horas" name="horas" value="<?php echo $practica_horas ?>"/>
                            <input type="hidden" id="id-carrera" name="id-carrera" value="<?php echo $practica_id_carrera ?>"/>
                            <button type="submit" class="btn btn-outline-secondary">Plan de trabajo</button>
                        </form>
                    </div>

                </div>
            </div>

            <h2>Carga de documentos</h2>
            <hr>

            <form action="subirDocumentos.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="practica-id" id="practica-id" value=<?php echo $practica_id?>>

                <div class="form-group col-md-3">
                    <div class="custom-file ">
                        <label class="custom-file-label" for="solicitud">Solicitud de inicio de prácticas</label>
                        <input required type="file" class="custom-file-input" id="solicitud" name="solicitud">
                        <p id="solicitud-name"></p>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <div class="custom-file ">
                        <label class="custom-file-label" for="plan-trabajo">Plan de trabajo</label>
                        <input required type="file" class="custom-file-input" id="plan-trabajo" name="plan-trabajo">
                        <p id="plan-trabajo-name"></p>

                    </div>
                </div>

                <div class="form-group col-md-3">
                    <div class="custom-file">
                        <label class="custom-file-label" for="carta-aceptacion">Carta de aceptación</label>
                        <input required type="file" class="custom-file-input" id="carta-aceptacion" name="carta-aceptacion">
                        <p id="carta-aceptacion-name"></p>
                    </div>
                </div>
                <div class='form-group col-md-12'>
                    <div class='form-row justify-content-start align-items-center'>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <a href="./editar-practica.php" style="margin-left: 10px">Editar formulario</a>
                    </div>
                </div>
            </form>

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
