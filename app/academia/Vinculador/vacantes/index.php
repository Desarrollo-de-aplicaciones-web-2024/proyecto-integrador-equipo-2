<?php
require_once '../../../../config/global.php';

define('RUTA_INCLUDE', '../../../../'); //ajustar a necesidad
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

<!--            <nav aria-label="breadcrumb">-->
<!--                <ol class="breadcrumb">-->
<!--                    <li class="breadcrumb-item">Catálogos</li>-->
<!--                    <li class="breadcrumb-item active" aria-current="page">Nombre del catálogo</li>-->
<!--                </ol>-->
<!--            </nav>-->

<!--            <div class="alert alert-success" role="alert">-->
<!--                <i class="fas fa-check"></i> Mensaje de éxito-->
<!--            </div>-->
<!---->
<!--            <div class="alert alert-danger" role="alert">-->
<!--                <i class="fas fa-exclamation-triangle"></i> Mensaje de error-->
<!--            </div>-->

            <div class="row my-3">
                <div class="col text-right">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        + Agregar convocatoria
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Convocatoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered dataTable">
                    <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <th>N° de vacantes</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <th>N° de vacantes</th>
                        <th>Contacto</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td>Intellia</td>
                        <td>14 de marzo</td>
                        <td>4</td>
                        <td>contacto@gmail.com</td>
                        <td>
                            <a href="#" class="btn btn-link btn-sm btn-sm"><img src="/img/editar.png" width="20" height="20" alt="imagen editar" title="Editar"/>
                                <a href="#" class="btn btn-link btn-sm"><img src="/img/eliminar.png" width="20" height="20" alt="imagen eliminar" title="Eliminar"</img></a>
                        </td>

                    </tr>
                    <tr>
                        <td>Tamsa</td>
                        <td>20 de marzo</td>
                        <td>Indefinido</td>
                        <td>contacto@gmail.com</td>
                        <td>
                            <a href="#" class="btn btn-link btn-sm btn-sm">
                                <img src="/img/editar.png" width="20" height="20" alt="imagen editar" title="Editar"/>
                            </a>

                                <a href="#" class="btn btn-link btn-sm">
                                    <img src="/img/eliminar.png" width="20" height="20" alt="imagen eliminar" title="Eliminar"/>
                                </a>
                        </td>
                    </tr>
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

<?php getModalLogout() ?>

<?php getBottomIncudes( RUTA_INCLUDE ) ?>
</body>

</html>
