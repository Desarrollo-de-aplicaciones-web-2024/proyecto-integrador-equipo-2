<?php
require_once '../../config/global.php';

define('RUTA_INCLUDE', '../../'); //ajustar a necesidad
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de alumnos</title>
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
                    <li class="breadcrumb-item">Administración</li>
                    <li class="breadcrumb-item active" aria-current="page">Registro de Alumnos</li>
                </ol>
            </nav>

<!--            <div class="alert alert-success" role="alert">-->
<!--                <i class="fas fa-check"></i> Mensaje de éxito-->
<!--            </div>-->
<!---->
<!--            <div class="alert alert-danger" role="alert">-->
<!--                <i class="fas fa-exclamation-triangle"></i> Mensaje de error-->
<!--            </div>-->


        </div>

        <!-- /.container-fluid -->

        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <button type="button" class="btn btn-success">Guardar</button>
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-link">Cancelar</button>
                </div>
            </div>

            <form>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputMatricula">Matrícula</label>
                        <input type="text" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNombre">Nombre</label>
                        <input type="text" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group col-md-1">
                    <label for="inputSexo">Sexo</label>
                    <select id="inputSemestre" class="form-control">
                        <option selected>H</option>
                        <option>M</option>
                    </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3.5">
                        <label for="inputCarrera">Carrera</label>
                        <select id="inputCarrera" class="form-control">
                            <option selected>Ing. en Sistemas Computacionales</option>
                            <option>Telecomunicaciones</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                    <label for="inputCampus">Campus</label>
                    <select id="inputSemestre" class="form-control">
                        <option selected>Calazans</option>
                        <option>Torrente</option>
                    </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-1">
                        <label for="inputSemestre">Semestre</label>
                        <select id="inputSemestre" class="form-control">
                            <option selected>3°</option>
                            <option>4°</option>
                        </select>
                    </div>


                </div>
            </form>
        </div>
        <!-- /.container -->

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
