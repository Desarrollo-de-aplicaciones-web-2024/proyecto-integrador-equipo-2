<?php
session_start();
require_once '../../config/global.php';
require_once '../../config/db.php';
define('RUTA_INCLUDE', '../../');

$mat_alumno = isset($_SESSION['matricula']) ? $_SESSION['matricula'] : null;

if (!$mat_alumno) {
    header('Location: ../index.php');
    exit();
}

//checar si esta en revision
$sql_revision = "select * from practicas WHERE matricula_alumno = '$mat_alumno' AND NOT estatus = 'pendiente'";
$res = mysqli_query($conexion, $sql_revision);
if ($res && mysqli_num_rows($res) > 0) {

    //obtener datos del alumno
    $sql_alumno = "SELECT a.nombre, a.semestre, p.estatus FROM alumnos a LEFT JOIN practicas p ON a.matricula = p.matricula_alumno WHERE a.matricula = '$mat_alumno';";
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

} else {
    header('Location: inicio-practicas.php');
    exit();
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
        .card {
            transition: all 0.3s ease-in-out;
        }
        .card-body {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body id="page-top">

<?php getNavbar() ?>

<div id="wrapper">

    <?php getSidebarAlumno('../alumnos/', $semestre, $practica_status); ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item active" aria-current="page">Mis prácticas</li>
                </ol>

            </nav>

            <!-- Page Content -->
            <div class="row align-items-center justify-content-between mx-2">
                <h1>Mis prácticas</h1>

                <div>
                    <a class="btn btn-outline-primary" href="inicio-practicas.php">Nuevo periodo de practicas</a>
                </div>
            </div>


            <hr>
            <br>
            <?php
                $sql_practicas = "select * from practicas where matricula_alumno = '$mat_alumno'";

                $res = mysqli_query($conexion, $sql_practicas);
                while ($practica = mysqli_fetch_assoc($res)) {

                    $sql_empresa = "SELECT e.*, g.nombre AS nombre_giro FROM empresas e JOIN giros g ON e.giro = g.id WHERE e.id = {$practica['id_empresa']};";
                    $res_empresa = mysqli_query($conexion, $sql_empresa);
                    $empresa = mysqli_fetch_assoc($res_empresa);

                    //para que las fechas no se muestren con formato ingles
                    $fecha_inicio = new DateTime($practica['fecha_inicio']);
                    $fecha_fin = new DateTime($practica['fecha_fin']);


                    $fecha_inicio_formateada = $fecha_inicio->format('d/m/Y');
                    $fecha_fin_formateada = $fecha_fin->format('d/m/Y');

                    $btnType = "";
                    $btnText = "";

                    switch ($practica['estatus']) {
                        case "revision":
                            $destination = '#';
                            $btnType = "btn-warning";
                            $btnText = "En Revisión";
                            break;
                        case "finalizado":
                            $btnType = "btn-secondary";
                            $destination = '#';
                            $btnText = "Finalizado";
                            break;
                        case "activo":
                            $btnType = "btn-success";
                            $btnText = "Activo";
                            $destination = '../consultas/procesos/seguimiento.php';
                            break;

                        case "cancelado":
                            $btnType = "btn-danger";
                            $btnText = "Cancelado";
                            $destination = '#';
                            break;

                        case "pendiente":
                            $btnType = "btn-primary";
                            $btnText = "Editar";
                            $destination = 'editar-documentos-iniciales.php';
                            break;
                    }

                    //obtener los dccumentos
                    $sql_documentos = "SELECT * from documentos WHERE id_practica = {$practica['id']};";
                    $res_documentos = mysqli_query($conexion, $sql_documentos);

                    while ($documento = mysqli_fetch_assoc($res_documentos)) {
                        if ($documento['tipo'] == 'solicitud') {
                            $solicitud_motivos = $documento['motivo'];
                            $solicitud_check = $documento['motivo'] ? "<i class='fas fa-times-circle' style='color: red;'></i>"  : "<i class='fas fa-check-circle' style='color: green;'></i>";
                        }

                        if ($documento['tipo'] == 'plan-trabajo') {
                            $plan_motivos = $documento['motivo'];
                            $plan_check = $documento['motivo'] ? "<i class='fas fa-times-circle' style='color: red;'></i>"  : "<i class='fas fa-check-circle' style='color: green;'></i>";
                        }

                        if ($documento['tipo'] == 'carta-aceptacion') {
                            $carta_motivos = $documento['motivo'];
                            $carta_check = $documento['motivo'] ? "<i class='fas fa-times-circle' style='color: red;'></i>"  : "<i class='fas fa-check-circle' style='color: green;'></i>";
                        }
                    }

                    if (empty($solicitud_motivos) && empty($plan_motivos) && empty($carta_motivos)) {
                        $motivos = "<h5>Todos los documentos en orden</h5>";


                    } else {
                        $motivos = <<<EOD
                                    <p>{$solicitud_check} <b>Solicitud de prácticas:</b> {$solicitud_motivos}</p>
                                    <p>{$plan_check} <b>Plan de trabajo:</b> {$plan_motivos}</p>
                                    <p>{$carta_check} <b>Carta de aceptacion:</b> {$carta_motivos}</p>
                                     
                                EOD;
                    }




                    //si alguno de los documentos esta rechazado, etnocens inficar con el mensaje


                    echo <<<EOD
                            <div class="card w-75 mx-auto mb-3">
                              <div class="card-body row justify-content-around align-items-center">
                                <div class="row w-50 justify-content-between align-items-center">
                                  <div>
                                    <h5 class="card-title" style="margin-bottom: 0;">{$empresa['nombre']}</h5>
                                    <p class="card-text" style="margin-bottom: 0; color: #7E7E7E; font-size: 14px ">{$empresa['nombre_giro']}</p>
                                  </div>
                                  <div>
                                    <p class="card-text" style="margin-bottom: 0; font-size: 14px">Periodo de prácticas</p>
                                    <p class="card-text" style="margin-bottom: 0; color: #7E7E7E; font-size: 14px">{$fecha_inicio_formateada} <b>-</b> {$fecha_fin_formateada}</p>
                                  </div>
                                </div>
                                <a href="{$destination}" class="btn {$btnType}">{$btnText}</a>
                                  <i type="button" class="fas fa-chevron-down text-dark" data-toggle="collapse" data-target="#collapse-{$practica['id']}" aria-expanded="false" aria-controls="collapse-{$practica['id']}"></i>
                                </button>
                              </div>
                              <div class="collapse" id="collapse-{$practica['id']}">
                                <div class="card card-body">
                                    {$motivos}
                                </div>
                              </div>
                            </div>
                            EOD;



                }
            ?>

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
