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
</head>

<body id="page-top">

<?php getNavbar() ?>

<div id="wrapper">

    <?php getSidebar() ?>

    <div id="content-wrapper">

        <div class="container-fluid">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Catálogos</li>
                    <li class="breadcrumb-item active" aria-current="page">Alumnos</li>
                </ol>
            </nav>



            <div class="row my-3">
                <div class="col text-right">
                    <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo</button>
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered dataTable">
                    <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>Semestre</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        <th>Semestre</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($data as $alumno):?>
                        <tr>
                            <td><?php echo $alumno[0]?></td>
                            <td><?php echo $alumno[1]?></td>
                            <td><?php echo $alumno[2]?></td>
                            <td><?php echo $alumno[3]?></td>
                            <td>
                                <button type="button" class="btn btn-link btn-sm" onclick="mostrarDetalles('<?php echo $alumno[0]?>', '<?php echo $alumno[1]?>', '<?php echo $alumno[3]?>')">Detalles</button>
                            </td>
                        </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
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

<!-- Detalles Modal -->
<div class="modal fade" id="detallesModal" tabindex="-1" role="dialog" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detallesModalLabel">Detalles del Alumno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="detallesLista">
                    <!-- Aquí se mostrarán los detalles del alumno -->
                </ul>
                <hr>
                <div>
                    <p>Progreso</p>
                    <div class="progress">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php getModalLogout() ?>

<?php getBottomIncudes(RUTA_INCLUDE) ?>

<script>
    function mostrarDetalles(matricula, nombre, semestre) {
        // Limpia el contenido anterior
        document.getElementById('detallesLista').innerHTML = '';

        // Crea la lista de detalles
        var detallesLista = document.getElementById('detallesLista');
        var matriculaItem = document.createElement('li');
        matriculaItem.textContent = 'Matrícula: ' + matricula;
        var nombreItem = document.createElement('li');
        nombreItem.textContent = 'Nombre: ' + nombre;
        var semestreItem = document.createElement('li');
        semestreItem.textContent = 'Semestre: ' + semestre;

        detallesLista.appendChild(matriculaItem);
        detallesLista.appendChild(nombreItem);
        detallesLista.appendChild(semestreItem);

        // Actualiza el progreso de la barra
        actualizarProgreso();

        // Muestra el modal
        $('#detallesModal').modal('show');
    }

    function actualizarProgreso() {
        var progressBar = document.getElementById('progressBar');
        var width = 0;
        var id = setInterval(frame, 10);

        function frame() {
            if (width >= 100) {
                clearInterval(id);
            } else {
                width++;
                progressBar.style.width = width + '%';
                progressBar.setAttribute('aria-valuenow', width);
                progressBar.textContent = width + '%';
            }
        }
    }
</script>

</body>

</html>
