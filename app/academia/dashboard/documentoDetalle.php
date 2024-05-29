<?php
require_once '../../../config/global.php';


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
                        <h2>Solicitud de inicio de prácticas</h2>
                        <h4>Fecha de subida: 01/05/2024</h4>

                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nombre:</strong> Enviosperros</li>
                            <li class="list-group-item"><strong>Domicilio:</strong> La vecindad del chavo</li>
                            <li class="list-group-item"><strong>Teléfono</strong> 2299123456</li>
                            <li class="list-group-item"><strong>Correo:</strong> enviosperros@gmail.com</li>
                            <li class="list-group-item"><strong>Giro:</strong> Logística</li>
                        </ul>
                    </div>
                    <div class="col mt-5">
                        <h3>Documentos</h3>
                        <div class="d-flex align-items-center mt-3">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-file-pdf" style="font-size: 3.5rem;"></i>
                                <p class="text-center">Archivo: Cartita.pdf</p>
                            </div>
                            <div class="d-flex flex-column align-items-center ml-3">
                                <i class="fas fa-file-pdf" style="font-size: 3.5rem;"></i>
                                <p class="text-center">Archivo: Cartita.pdf</p>
                            </div>
                        </div>
                        <div class="mt-3 block btn-group w-100">
                            <button class="btn btn-danger" data-toggle="modal" data-target="#modalRechazar">Rechazar</button>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalAprobar">Aprobar</button>
                        </div>
                    </div>
                </div>

                <!-- PDF Preview Column -->
<!--                <div class="col-md-8 mb-4">-->
<!--                    <h4>File Preview</h4>-->
<!--                    <div id="pdf-preview"></div>-->
<!--                </div>-->

                <div class="col-md-8 mb-4">
                    <h4>Vista previa</h4>
                    <iframe src="http://proyecto-integrador-equipo-2.test/storage/reports/example.pdf" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <?php getFooter() ?>

    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="modalRechazar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">¿Seguro de que desea rechazar este documento?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <p>Al rechazar este documento, el alumno deberá subir un nuevo documento.</p>

                    <label for="rechazo">Motivo del rechazo</label>
                    <textarea name="rechazo" id="rechazo" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger">Rechazar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalAprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Seguro de que desea aprobar este documento?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Al aprobar este documento, el alumno podrá continuar con el proceso de prácticas profesionales.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success">Aprobar</button>
                </div>
            </div>
        </div>
    </div>

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
