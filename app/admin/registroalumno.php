<?php
require_once '../../config/global.php';
require '../../config/db.php';

define('RUTA_INCLUDE', '../../'); //ajustar a necesidad
$sql = "SELECT nombre FROM carreras";
$result = $conexion->query($sql);
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
            <form action="guardaralumno.php" method="post">
            <div class="row mb-5">
                <div class="col">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
                <div class="col text-right">
                    <button type="reset" class="btn btn-link">Cancelar</button>
                </div>
            </div>


                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputMatricula">Matrícula</label>
                        <input type="text" class="form-control" id="matricula" name="matricula">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>
                    <div class="form-group col-md-2">
                    <label for="inputSexo">Sexo</label>
                    <select id="inputSemestre" class="form-control" id="sexo" name="sexo">
                        <option selected>H</option>
                        <option>M</option>
                    </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3.5">
                        <label for="inputCarrera">Carrera</label>
                        <select id="inputCarrera" class="form-control" id="carrera" name="carrera">
                            <?php
                            if ($result->num_rows > 0) {
                                // Iterar sobre los resultados
                                while($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["nombre"] . '">' . $row["nombre"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="inputSemestre">Semestre</label>
                        <select id="inputSemestre" class="form-control" id="semestre" name="semestre">
                            <option selected>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control">
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
