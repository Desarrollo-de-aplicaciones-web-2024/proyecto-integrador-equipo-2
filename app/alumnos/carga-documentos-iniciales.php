<?php
session_start();
require '../../config/db.php';
require_once '../../config/global.php';
define('RUTA_INCLUDE', '../../'); //ajustar a necesidad

$status = isset($_SESSION['status']) ? $_SESSION['status'] : null;
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
$practica = isset($_SESSION['fila_creada']) ? $_SESSION['fila_creada'] : null;

// Limpiar datos de sesión si ya no se necesitan
unset($_SESSION['fila_creada']);
unset($_SESSION['status']);
unset($_SESSION['mensaje']);
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

    <?php getSidebar() ?>

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
                <form target="_blank" action="generarPdf.php" method="post">
                    <input type="hidden" id="id-empresa" name="id-empresa" value="<?php echo $practica['id_empresa'] ?>"/>
                    <input type="hidden" id="matricula" name="matricula" value="<?php echo $practica['matricula_alumno'] ?>"/>
                    <input type="hidden" id="duracion" name="duracion" value="<?php echo $practica['duracion'] ?>"/>
                    <input type="hidden" id="puesto" name="puesto" value="<?php echo $practica['puesto'] ?>"/>
                    <input type="hidden" id="departamento" name="departamento" value="<?php echo $practica['departamento'] ?>"/>
                    <input type="hidden" id="horas" name="horas" value="<?php echo $practica['horas'] ?>"/>
                    <input type="hidden" id="fecha-inicio" name="fecha-inicio" value="<?php echo $practica['fecha_inicio'] ?>"/>
                    <input type="hidden" id="fecha-fin" name="fecha-fin" value="<?php echo $practica['fecha_fin'] ?>"/>
                    <input type="hidden" id="supervisor" name="supervisor" value="<?php echo $practica['supervisor'] ?>"/>
                    <input type="hidden" id="puesto-supervisor" name="puesto-supervisor" value="<?php echo $practica['puesto_supervisor'] ?>"/>

                    <button type="submit">Generar documento</button>
                </form>


            <form action="" method="post">

                <div class="form-group col-md-3">
                    <div class="custom-file ">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Solicitud de inicio de prácticas</label>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <div class="custom-file ">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Plan de trabajo</label>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <div class="custom-file ">
                        <input type="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Carta de aceptación</label>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Enviar</button>
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
