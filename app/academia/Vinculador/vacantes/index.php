<?php
require_once '../../../../config/global.php';

define('RUTA_INCLUDE', '../../../../'); //ajustar a necesidad
require_once '../../../../config/db.php';
global $conexion;
$query = "SELECT * FROM convocatorias as c JOIN empresas as e ON c.id_empresa = e.id;";

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

    <?php getTopIncludes(RUTA_INCLUDE ) ?>
</head>

<body id="page-top">

<?php getNavbar() ?>

<div id="wrapper">

    <?php getSidebar() ?>

    <div id="content-wrapper">

        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Convocatorias</li>
                    <li class="breadcrumb-item active" aria-current="page">Registro de convocatorias</li>
                </ol>
            </nav>
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

                                    <!--Aquí está el formulario -->
                                    <form action="nueva.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label for="inputEmpresa" class="col-sm-2 col-form-label">Empresa: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputEmpresa" name="empresa" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDesc" class="col-sm-2 col-form-label">Descripción: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputDesc" name="descripcion" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">Imagen: </label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="imagen" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Correo: </label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail" name="correo" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputTelefono" class="col-sm-2 col-form-label">Teléfono: </label>
                                            <div class="col-sm-10">
                                                <input type="tel" class="form-control" id="inputTelefono" name="telefono" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputCarrera" class="col-sm-2 col-form-label">Perfiles: </label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="perfiles[]" value="Sistemas Computacionales">
                                                <label class="form-check-label" for="inlineCheckbox1">Sistemas Computacionales</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="perfiles[]" value="Telecomunicaciones">
                                                <label class="form-check-label" for="inlineCheckbox2">Telecomunicaciones</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputCantidadVacantes" class="col-sm-2 col-form-label">Vacantes disponibles: </label>
                                            <select id="inputCantidadVacantes" class="col-sm-2" name="vacantes" required>
                                                <option selected disabled value="">Selecciona</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>Indefinida</option>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </form>

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
                        <th>Descripción</th>
                        <th>Contacto</th>
                        <th>Perfiles</th>
                        <th>Vacantes</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Empresa</th>
                        <th>Descripción</th>
                        <th>Contacto</th>
                        <th>Perfiles</th>
                        <th>Vacantes</th>
                        <th>Acciones</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($data as $empresa): ?>
                        <tr>
                            <td><?php echo $empresa[8] ?></td>
                            <td><?php echo $empresa[3] ?></td>
                            <td>
                                <p><strong>Correo: </strong><br><?php echo $empresa[9]?></p><br>
                                <p><strong>Teléfono: </strong><br><?php echo $empresa[10]?></p>
                            </td>
                            <td><?php echo $empresa[2]?></td>
                            <td><?php echo $empresa[11]?></td>
                            <td>
                                <a href="#" class="btn btn-primary" >Editar</a>
                                <button id="toggleButton" class="btn btn-primary">Ocultar</button>
                                <a href="#" class="btn btn-primary">Imagen</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
