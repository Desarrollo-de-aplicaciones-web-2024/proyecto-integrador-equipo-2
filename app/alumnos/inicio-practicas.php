<?php

require '../../config/db.php';
require_once '../../config/global.php';
define('RUTA_INCLUDE', '../../'); //ajustar a necesidad
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

            <!-- Page Content -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item active" aria-current="page">Documentación inicial</li>
                </ol>
            </nav>

            <hr>

            <form action="" method="post">
                <div class="form-row">
                    <div class='form-group col-md-4'>
                        <label for="giro">Nombre o razón social de la empresa</label>
                        <select  required class="custom-select" id="giro" name="giro">
                            <option selected value="">Seleccione empresa...</option>
                            <?php
                            $sql_select = "SELECT id,nombre FROM empresas";
                            $res = mysqli_query($conexion, $sql_select);

                            if ($res) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value=' . $row['id'] . '>' . $row['nombre'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, seleccione el giro.
                        </div>
                    </div>

                    <div class='form-group col-md-4'>
                        <label for="giro">Giro de la empresa</label>
                        <select  required class="custom-select" id="giro" name="giro">
                            <option selected value="">Seleccione un giro...</option>
                            <?php
                            $sql_select = "SELECT id,nombre FROM giros";
                            $res = mysqli_query($conexion, $sql_select);

                            if ($res) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo '<option value=' . $row['id'] . '>' . $row['nombre'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, seleccione el giro.
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputAddress">Dirección</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Dirección de la empresa">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputAddress">Teléfono</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Teléfono de la empresa">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Correo de contacto</label>
                        <input type="email" class="form-control" id="inputPassword4" placeholder="Correo de la empresa">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputCity">Puesto tentativo a desempeñar</label>
                        <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputState">Duración de periodo de prácticas</label>
                        <select id="inputState" class="form-control">
                            <option selected>Selecciona...</option>
                            <option>3 meses</option>
                            <option>6 meses</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputZip">Departamento</label>
                        <input type="text" class="form-control" id="inputZip" placeholder="Departamento en el que te vas a quedar ">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="inputZip">Horas estimadas</label>
                        <input type="number" class="form-control" id="inputZip" placeholder="Horas">
                    </div>

                    <div class="form-group col-md-1">
                        <label for="inputZip">Fecha de inicio</label>
                        <input type="date" class="form-control" id="inputZip" placeholder="Horas">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Siguiente</button>
            </form>

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
