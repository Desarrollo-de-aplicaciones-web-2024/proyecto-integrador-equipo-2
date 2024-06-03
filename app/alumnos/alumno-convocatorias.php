<?php
require_once '../../config/global.php';
define('RUTA_INCLUDE', '../../'); //ajustar a necesidad
require_once '../../config/db.php';
$query = "SELECT * FROM convocatorias as c JOIN empresas as e ON c.id_empresa = e.id;";
$res = mysqli_query($conexion,$query);

//    $stmt = mysqli_prepare($conexion, $query);
//    mysqli_stmt_execute($stmt);
//    $result = mysqli_stmt_get_result($stmt);
//    $data = mysqli_fetch_all($result);
//    mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <style>
        .card img {
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
        }
        .card img.enlarged {
            transform: scale(2);
            z-index: 1000;
            position: relative;
        }
    </style>


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
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item active" aria-current="page">Convocatorias</li>
                </ol>
            </nav>

            <div class="container mt-5">
                <div class="d-flex flex-wrap">

                    <?php
                        while ($row = mysqli_fetch_assoc($res)){
                            if ($row['visible']) {
                                $vacantes =$row['vacantes'] == 0 ? "Indefinido": $row['vacantes'];
                                $src = "../academia/Vinculador/vacantes/" . $row['imagen'];
                                $html = <<<EOD
                                <div class="card mb-3" style="flex: 0 1 calc(33.33% - 1rem); margin: 0.5rem;">
                                    <div class="row no-gutters">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                                            <img alt={$row['imagen']} src={$src} class="img-fluid" alt="..." onclick="showImageModal(this.src)">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <h5 class="card-title">{$row['titulo']}</h5>
                                                <h6 class="card-subtitle">{$row['nombre']}</h6>
                                                <br>
                                                <p class="card-text">{$row['descripcion']}</p>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <p><strong>Correo: </strong><br>{$row['email']}</p><br>
                                                        <p><strong>Teléfono: </strong><br>{$row['telefono']}</p>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <p><strong>Vacantes: </strong>{$vacantes}</p>
                                                    </li>
                                                </ul>
                                                <p class="card-text"><small class="text-muted">Última actualización hace 3 minutos</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            EOD;
                                echo $html;
                            }

                        }
                    ?>

<!--                    --><?php //foreach ($data as $empresa): ?>
<!--                        <div class="card mb-3" style="flex: 0 1 calc(33.33% - 1rem); margin: 0.5rem;">-->
<!--                            <div class="row no-gutters">-->
<!--                                <div class="col-md-12 d-flex justify-content-center align-items-center">-->
<!--                                    <img src="../../img/Intellia.png" class="img-fluid" alt="..." onclick="showImageModal(this.src)">-->
<!--                                </div>-->
<!--                                <div class="col-md-12">-->
<!--                                    <div class="card-body">-->
<!--                                        <h5 class="card-title">--><?php //echo $empresa[8]?><!--</h5>-->
<!--                                        <p class="card-text">--><?php //echo $empresa[3]?><!--</p>-->
<!--                                        <ul class="list-group list-group-flush">-->
<!--                                            <li class="list-group-item">-->
<!--                                                <p><strong>Correo: </strong><br>--><?php //echo $empresa[9]?><!--</p><br>-->
<!--                                                <p><strong>Teléfono: </strong><br>--><?php //echo $empresa[10]?><!--</p>-->
<!--                                            </li>-->
<!--                                            <li class="list-group-item">-->
<!--                                                <p><strong>Perfiles: </strong>--><?php //echo $empresa[2]?><!--</p>-->
<!--                                            </li>-->
<!--                                            <li class="list-group-item">-->
<!--                                                <p><strong>Vacantes: </strong>--><?php //echo $empresa[11]?><!--</p>-->
<!--                                            </li>-->
<!--                                        </ul>-->
<!--                                        <p class="card-text"><small class="text-muted">Última actualización hace 3 minutos</small></p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //endforeach; ?>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="" class="img-fluid" id="modalImage" alt="...">
                        </div>
                    </div>
                </div>
            </div>




            <script>
                function showImageModal(src) {
                    document.getElementById("modalImage").src = src;
                    $('#imageModal').modal('show');
                }
            </script>




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
