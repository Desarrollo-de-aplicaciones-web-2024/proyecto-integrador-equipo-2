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
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Datos de la convocatoria</h5>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group row">
                                            <label for="inputTitulo" class="col-sm-2 col-form-label">Título: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputTitulo">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDescripcion" class="col-sm-2 col-form-label">Descripción: </label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmpresa" class="col-sm-2 col-form-label">Empresa: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputEmpresa">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">Imagen: </label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control-file" id="exampleFormControlFile1">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Datos de contacto: </label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail" placeholder="Correo electrónico">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputCarrera" class="col-sm-2 col-form-label">Perfiles: </label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                    <label class="form-check-label" for="inlineCheckbox1">Sistemas Computacionales</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                    <label class="form-check-label" for="inlineCheckbox2">Telecomunicaciones</label>
                                                </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputCantidadVacantes" class="col-sm-2 col-form-label">Cantidad de vacantes</label>
                                            <select id="inputCantidadVacantes" class="col-sm-1">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>Indefinida</option>
                                            </select>
                                        </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary">Guardar</button>
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
