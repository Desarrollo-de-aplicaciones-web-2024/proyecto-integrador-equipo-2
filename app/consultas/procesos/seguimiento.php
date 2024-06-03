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

        /*Esto es el cuadrado del centro :) */
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
            display: flex;
            justify-content: center;
            align-items: center;
            color: #1a237e; /* Color de los números */
            font-weight: bold; /* Para que los números sean más visibles */
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

        #modalReporte .actividades-realizadas textarea {
            width: 100%; /* Ancho del 100% del contenedor */
            max-width: 100%; /* Ancho máximo del 100% del contenedor */
        }

        #modalReporte .btn-guardar {
            background-color: #1a237e;
            color: #ffffff;
        }

        #modalReporte .btn-cancelar {
            background-color: #d32f2f;
            color: #ffffff;
        }

        #modalReporte .modal-title,
        #modalReporte .fecha-limite,
        #modalReporte .subir-reporte,
        #modalReporte .datos-alumno,
        #modalReporte .horas-realizadas,
        #modalReporte .actividades-realizadas {
            color: #1a237e; /* Tengo sueño */
        }

        #breadcrumb-nav {
            background-color: #1a237e; /* Fondo azul marino */
            color: #1a237e;
            font-weight: bold; /* Texto en negritas */
            font-family: Arial, sans-serif; /* Fuente distinta */
            padding: 10px; /* Añadir un poco de espacio alrededor del texto */
        }

    </style>
</head>

<body id="page-top">

<?php getNavbar() ?>

<div id="wrapper">

    <?php getSidebar() ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <nav aria-label="breadcrumb" id="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Checa tu progreso actual de prácticas profesionales</li>
                </ol>
            </nav>

            <div id="cuadroCentral">
                <!-- Cuadro central con el contenido previo -->
                <div id="cuadroCentral">
                    <?php
                    // Obtener un nombre aleatorio de la tabla de alumnos
                    $nombreAleatorio = $data[array_rand($data)][1];
                    $query = "SELECT * FROM alumnos WHERE nombre = ?";
                    $stmt = mysqli_prepare($conexion, $query);
                    mysqli_stmt_bind_param($stmt, 's', $nombreAleatorio);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $alumno = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($stmt);
                    // Obtener la fecha de hoy
                    $fechaHoy = date('d/m/Y');
                    ?>
                    <div id="nombreAlumno"><?php echo $nombreAleatorio ?></div>
                    <div>Inicio: <?php echo $fechaHoy ?></div>
                    <div id="progreso">
                        <div class="circulo">1</div>
                        <div class="circulo">2</div>
                        <div class="circulo">3</div>
                        <div class="circulo">4</div>
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
                            <form action="archivos.php" method="post" enctype="multipart/form-data">
                            <div class="subir-reporte">Subir Reporte <input type="file" name="socrates"></div>
                            <div class="datos-alumno">Nombre: <?php echo $alumno['nombre'] ?> | Matrícula: <?php echo $alumno['matricula'] ?> | Semestre: <?php echo $alumno['semestre'] ?></div>
                            <div class="horas-realizadas">Horas realizadas: <input type="number"></input> Periodo reportado: <input type="date"> - <input type="date"></div>
                            <div class="actividades-realizadas">
                                <div>Actividades realizadas durante el mes</div>
                                <textarea></textarea>
                            </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-guardar">
                                    <button type="button" class="btn btn-cancelar" data-dismiss="modal">CANCELAR</button>
                                </div>
                            </form>
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
