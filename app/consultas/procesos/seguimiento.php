<?php
require_once '../../../config/global.php';
require_once '../../../config/db.php';

define('RUTA_INCLUDE', '../../../');
global $conexion;
$query = "SELECT * FROM alumnos";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_all($result);
mysqli_stmt_close($stmt);
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

    <?php getTopIncludes(RUTA_INCLUDE) ?>

    <style>
        #cuadroCentral {
            width: 300px;
            height: 300px;
            background-color: #f8f9fc;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: auto;
            margin-top: 50px;
        }

        #nombreAlumno {
            color: #1a237e;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 10px;
        }

        #progreso {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .circulo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 0px 10px;
            border: 2px solid #1a237e;
        }

        .circulo.verde {
            background-color: #4caf50;
            border-color: #4caf50;
        }

        #subirReporte {
            background-color: #1a237e;
            color: #ffffff;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }


        /* Estilos adicionales para el modal */
        #modalReporte .modal-dialog {
            max-width: 90%;
        }

        #modalReporte .modal-title {
            text-align: center;
            color: #1a237e;
            font-weight: bold;
        }

        #modalReporte .fecha-limite {
            text-align: right;
            color: #1a237e;
            margin-bottom: 10px;
        }

        #modalReporte .subir-reporte {
            font-weight: bold;
            margin-bottom: 10px;
        }

        #modalReporte .subir-archivo {
            background-color: #1a237e;
            color: #ffffff;
            border: none;
        }

        #modalReporte .datos-alumno {
            margin-bottom: 10px;
        }

        #modalReporte .horas-realizadas {
            margin-bottom: 10px;
        }

        #modalReporte .periodo-reportado {
            margin-bottom: 10px;
        }

        #modalReporte .actividades-realizadas,
        #modalReporte .observaciones {
            margin-bottom: 10px;
            height: 150px;
            overflow-y: auto;
        }

        #modalReporte .btn-guardar {
            background-color: #1a237e;
            color: #ffffff;
        }

        #modalReporte .btn-cancelar {
            background-color: #d32f2f;
            color: #ffffff;
        }
    </style>
</head>

<body id="page-top">

<?php getNavbar() ?>

<div id="wrapper">

    <?php getSidebar() ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Tu progreso</li>
                </ol>
            </nav>

            <div id="cuadroCentral">
                <!-- Cuadro central con el contenido previo -->
                <div id="cuadroCentral">
                    <?php
                    // Obtener un nombre aleatorio de la tabla de alumnos
                    $nombreAleatorio = $data[array_rand($data)][1];
                    // Obtener la fecha de hoy
                    $fechaHoy = date('d/m/Y');
                    ?>
                    <div id="nombreAlumno"><?php echo $nombreAleatorio ?></div>
                    <div>Inicio: <?php echo $fechaHoy ?></div>
                    <div id="progreso">
                        <div class="circulo"></div>
                        <div class="circulo"></div>
                        <div class="circulo"></div>
                        <div class="circulo"></div>
                    </div>
                    <button id="subirReporte">Subir Reporte</button>
                </div>

            </div>
            </div>

            <!-- Modal Reporte Mensual -->
            <div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="modalReporteTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalReporteTitle">Reporte Mensual</h5>
                            <div class="fecha-limite">Fecha Límite: <?php echo date('d/m/Y', strtotime('+1 month')) ?></div>
                        </div>
                        <div class="modal-body">

                            <div class="subir-reporte">Subir Reporte <button class="subir-archivo">Subir Archivo</button></div>
                            <div class="datos-alumno">Nombre: <?php echo $nombreAleatorio ?> | Matrícula: Matricula | Semestre: Semestre</div>
                            <div class="horas-realizadas">Horas realizadas: <input type="number"></input> Periodo reportado: <input type="date"> - <input type="date" readonly></div>
                            <div class="actividades-realizadas">
                                <div>Actividades realizadas durante el mes</div>
                                <textarea></textarea>
                            </div>
                            <div class="observaciones">
                                <div>Observaciones por parte del supervisor</div>
                                <textarea></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-guardar">Guardar</button>
                            <button type="button" class="btn btn-cancelar" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

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

<?php getBottomIncudes(RUTA_INCLUDE) ?>

<script>
    // Función para mostrar el modal de Reporte Mensual al hacer clic en el botón "Subir Reporte"
    document.getElementById('subirReporte').addEventListener('click', function() {
        $('#modalReporte').modal('show');
    });
</script>

</body>

</html>
