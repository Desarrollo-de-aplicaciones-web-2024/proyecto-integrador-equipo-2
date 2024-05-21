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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#nueva">
                        + Agregar convocatoria
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="nueva" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Datos de la convocatoria</h5>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group row">
                                            <label for="inputTitulo" class="col-sm-2 col-form-label">Empresa: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputTitulo" required>
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
                                            <label for="inputCantidadVacantes" class="col-sm-2 col-form-label">Vacantes disponibles: </label>
                                            <select id="inputCantidadVacantes" class="col-sm-2" required>
                                                <option selected disabled value="">Selecciona</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>Indefinida</option>
                                            </select>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Contacto: </label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail" placeholder="Correo electrónico" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">Imagen: </label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control-file" id="exampleFormControlFile1" required>
                                            </div>
                                        </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
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
                        <th>Perfiles</th>
                        <th>N° de vacantes</th>
                        <th>Datos de contacto</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Empresa</th>
                        <th>Perfiles</th>
                        <th>N° de vacantes</th>
                        <th>Datos de contacto</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td>Intellia</td>
                        <td>Sistemas computacionales</td>
                        <td>4</td>
                        <td>contacto@gmail.com</td>
                        <td>

                        </td>
                        <td>
                            <div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editar" >
                                    Editar
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="editar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editar convocatoria</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group row">
                                                        <label for="inputTitulo" class="col-sm-2 col-form-label">Empresa: </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="inputTitulo" required>
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
                                                        <label for="inputCantidadVacantes" class="col-sm-2 col-form-label">Vacantes disponibles: </label>
                                                        <select id="inputCantidadVacantes" class="col-sm-2" required>
                                                            <option selected disabled value="">Selecciona</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>Indefinida</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Contacto: </label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" id="inputEmail" placeholder="Correo electrónico" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">Imagen: </label>
                                                        <div class="col-sm-10">
                                                            <input type="file" class="form-control-file" id="exampleFormControlFile1" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar" >
                                    Eliminar
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="eliminar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h3>¿Desea eliminar esta convocatoria?</h3>
                                                <p>No podrá deshacer los cambios.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Tamsa</td>
                        <td>Sistemas computacionales<br>Telecomunicaciones</td>
                        <td>Indefinido</td>
                        <td>contacto@gmail.com</td>
                        <td>
                            aaa
                        </td>
                        <td>
                            <div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editar" >
                                    Editar
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="editar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editar convocatoria</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group row">
                                                        <label for="inputTitulo" class="col-sm-2 col-form-label">Empresa: </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="inputTitulo" required>
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
                                                        <label for="inputCantidadVacantes" class="col-sm-2 col-form-label">Vacantes disponibles: </label>
                                                        <select id="inputCantidadVacantes" class="col-sm-2" required>
                                                            <option selected disabled value="">Selecciona</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>Indefinida</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Contacto: </label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" id="inputEmail" placeholder="Correo electrónico" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">Imagen: </label>
                                                        <div class="col-sm-10">
                                                            <input type="file" class="form-control-file" id="exampleFormControlFile1" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#eliminar" >
                                    Eliminar
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="eliminar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <h3>¿Desea eliminar esta convocatoria?</h3>
                                                <p>No podrá deshacer los cambios.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
