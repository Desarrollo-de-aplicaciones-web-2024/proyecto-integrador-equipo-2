<?php
require_once '../../../config/global.php';
require_once '../../utils.php';
require_once '../../consultas/documentos.php';

global $documentTypes;

$document = Documento::getById($_GET['id']);

if (!$document) {
    header('Location: documentosPendientes.php');
}

setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain.1252');

// ignore warnings
error_reporting(E_ERROR | E_PARSE);

define('RUTA_INCLUDE', '../../../');
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

        <div class="container-fluid mt-5">
            <div class="row">
                <!-- Metadata Column -->
                <div class="col-md-4 mb-4">
                    <div class="col">
                        <h2><?= $documentTypes[$document['tipo']] ?></h2>
                        <h4>Fecha de subida: <?= strftime('%e de %B del %Y a las %H:%M', (new DateTime($document['fecha_creacion']))->getTimestamp()); ?></h4>

                        <ul class="list-group mt-4">
                            <li class="list-group-item active"><h4>Datos del periodo</h4></li>
                            <li class="list-group-item"><strong>Matrícula:</strong> <?= $document['practica']['alumno']['nombre'] ?></li>
                            <li class="list-group-item"><strong>Duración:</strong> <?= $document['practica']['duracion'] ?> meses</li>
                            <li class="list-group-item"><strong>Fecha de inicio:</strong> <?= strftime('%e de %B del %Y', (new DateTime($document['practica']['fecha_inicio']))->getTimestamp()); ?></li>
                            <li class="list-group-item"><strong>Puesto:</strong> <?= $document['practica']['puesto'] ?></li>
                            <li class="list-group-item"><strong>Actividades:</strong> <?= $document['practica']['actividades'] ?></li>
                        </ul>

                        <ul class="list-group mt-4">
                            <li class="list-group-item active"><h4>Datos de la empresa</h4></li>
                            <li class="list-group-item"><strong>Empresa:</strong> <?= $document['practica']['empresa']['nombre'] ?></li>
                            <li class="list-group-item"><strong>Domicilio:</strong> <?= $document['practica']['empresa']['direccion'] ?></li>
                            <li class="list-group-item"><strong>Teléfono</strong> <?= $document['practica']['empresa']['telefono'] ?></li>
                            <li class="list-group-item"><strong>Correo:</strong> <?= $document['practica']['empresa']['email'] ?></li>
                            <li class="list-group-item"><strong>Giro:</strong> <?= $document['practica']['empresa']['giro']['nombre'] ?></li>
                        </ul>
                    </div>
                    <div class="col mt-5">
                        <form action="revisar_documento.php" method="post" id="rechazarForm">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="mt-3 block btn-group w-100">
                                <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#rechazarModal">Rechazar</button>
                                <button class="btn btn-success" name="approve">Aprobar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- PDF Preview Column -->
                <div class="col-md-8 mb-4 pb-4">
                    <h4>Vista previa</h4>
                    <iframe src="http://proyecto-integrador-equipo-2.test/storage/reports/example.pdf" width="100%" height="100%"></iframe>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rechazarModal" tabindex="-1" aria-labelledby="rechazarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="revisar_documento.php" method="post" id="rechazarFormModal">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rechazarModalLabel">Razón de Rechazo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" name="motivo" rows="4" required></textarea>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-danger">Rechazar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var rechazarModal = new bootstrap.Modal(document.getElementById('rechazarModal'));
                document.querySelector('.btn-danger[data-bs-toggle="modal"]').addEventListener('click', function() {
                    rechazarModal.show();
                });
            });
        </script>

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
</body>
</html>
