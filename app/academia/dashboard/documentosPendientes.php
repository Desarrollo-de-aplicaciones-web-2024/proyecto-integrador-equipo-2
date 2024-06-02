<?php
require_once '../../../config/global.php';
require_once '../../consultas/documentos.php';
require_once '../../utils.php';

global $documentTypes;

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


        <div class="container-fluid">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Catálogos</li>
                    <li class="breadcrumb-item active" aria-current="page">Documentos pendientes</li>
                </ol>
            </nav>

            <!--            <div class="alert alert-success" role="alert">-->
            <!--                <i class="fas fa-check"></i> Mensaje de éxito-->
            <!--            </div>-->
            <!---->
            <!--            <div class="alert alert-danger" role="alert">-->
            <!--                <i class="fas fa-exclamation-triangle"></i> Mensaje de error-->
            <!--            </div>-->

            <!--            <div class="row my-3">-->
            <!--                <div class="col text-right">-->
            <!--                    <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo</button>-->
            <!--                </div>-->
            <!--            </div>-->


            <div class="table-responsive mb-3">
                <table class="table table-bordered dataTable">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Semestre</th>
                        <th>Empresa</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Semestre</th>
                        <th>Empresa</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    <?php foreach (Documento::getAll() as $documento): ?>
                        <?php if ($documento['estatus'] != 'pendiente') continue; ?>
                        <tr>
                            <td><?php echo $documento['practica']['alumno']['nombre'] ?></td>
                            <td><?php echo $documento['practica']['alumno']['semestre'] ?></td>
                            <td><?php echo $documento['practica']['empresa']['nombre'] ?></td>
                            <td><?php echo $documentTypes[$documento['tipo']] . ($documento['numero_reporte'] ? " ({$documento['numero_reporte']})" : '') ?>
                            </td>
                            <td>
                                <a href="documentoDetalle.php?id=<?= $documento['id'] ?>" class="btn btn-link btn-sm">Ver</a>
                                <a href="#" class="btn btn-link btn-sm">Editar</a>
                                <a href="#" class="btn btn-link btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->


    <?php getFooter() ?>

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
