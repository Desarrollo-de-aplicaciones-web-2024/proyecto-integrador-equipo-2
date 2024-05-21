<?php
require_once '../../../config/global.php';
require_once __DIR__ . '/../../consultas/empresas.php';

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
            <div class="d-flex justify-content-end mb-3">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filtrar
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
                        <a class="dropdown-item" href="#">Semana</a>
                        <a class="dropdown-item" href="#">Mes</a>
                        <a class="dropdown-item" href="#">3 meses</a>
                        <a class="dropdown-item" href="#">6 meses</a>
                        <a class="dropdown-item" href="#">Año</a>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title">Estudiantes activos</h5>
                            <p class="card-text display-4">123</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-success">
                        <div class="card-body">
                            <h5 class="card-title">Convenios activos</h5>
                            <p class="card-text display-4">45</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-warning">
                        <div class="card-body">
                            <h5 class="card-title">Horas registradas</h5>
                            <p class="card-text display-4">789</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-chart-bar"></i>
                            Practicantes por carrera
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-footer small text-muted">Actualizado hoy a las 11:59 PM</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-chart-pie"></i>
                            Practicantes por empresa
                        </div>
                        <div class="card-body">
                            <canvas id="myPieChart" width="100%" height="50"></canvas>
                        </div>
                        <div class="card-footer small text-muted">Actualizado ayer a las at 11:59 PM</div>
                    </div>
                </div>
            </div>
        </div>

        <?php getFooter() ?>

    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php getModalLogout() ?>

<?php getBottomIncudes(RUTA_INCLUDE) ?>
</body>
</html>
