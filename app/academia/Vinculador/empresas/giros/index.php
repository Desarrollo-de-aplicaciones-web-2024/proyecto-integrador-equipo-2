<?php
session_start();
require_once '../../../../../config/global.php';
require '../../../../../config/db.php';
define('RUTA_INCLUDE', '../../../../../'); //ajustar a necesidad

$status = isset($_SESSION['status']) ? $_SESSION['status'] : null;
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;

// Limpiar los datos recibidos
unset($_SESSION['status']);
unset($_SESSION['mensaje']);

function getRegistros($conexion) {

    $sql_select = "SELECT * FROM giros";
    $res = mysqli_query($conexion, $sql_select);

    // Mostrar los registros en una tabla
    if ($res) {
        echo '
          <div class="table-responsive mb-3">
                <table class="table table-bordered dataTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
                 </thead>
                ';
        while ($row = mysqli_fetch_assoc($res)) {
            $editModal = 'editModal' . $row['id']; // ID único para el modal
            $deleteModal = 'deleteModal' . $row['id']; // ID único para el modal

            echo '
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['nombre'] . '</td>
                    <td>' . $row['descripcion'] . '</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $editModal . '">Editar</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#' . $deleteModal . '">Eliminar</button>
                    </td>
                </tr>';

            echo "
            <!-- Modal de edición-->
            <div class='modal fade' id='" . $editModal . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel" . $row['id'] . "' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel" . $row['id'] . "'>Editar ID - " . $row['id'] . "</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <form action='actualizar.php' method='post' class='needs-validation' novalidate>
                                <div class='form-group'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <label for='nombre-modal-" . $row['id'] . "' class='col-form-label'>Nombre</label>
                                    <input required name='nombre' type='text' class='form-control' id='nombre-modal-" . $row['id'] . "' value='" . htmlspecialchars($row['nombre']) . "'>
                                </div>
                                <div class='form-group'>
                                    <label for='descripcion-modal-" . $row['id'] . "' class='col-form-label'>Descripción</label>
                                    <textarea required name='descripcion' class='form-control' id='descripcion-modal-" . $row['id'] . "'>" . htmlspecialchars($row['descripcion']) . "</textarea>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                                    <button type='submit' class='btn btn-primary' onclick='editar(". $row['id'] . ")'>Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            echo "<script>
                function editar(id) {
                    var nombre = document.getElementById('nombre-modal-' + id);
                    var descripcion = document.getElementById('descripcion-modal-' + id);
                
                    // Verificar si los campos están vacíos
                    if (nombre.value.trim() === '' || descripcion.value.trim() === '') {
                        if (nombre.value.trim() === '') {
                            nombre.classList.add('is-invalid');
                        }
                        if (descripcion.value.trim() === '') {
                            descripcion.classList.add('is-invalid');
                        }
                
                        //alert('Por favor, complete todos los campos.');
                        return; 
                }
            }

            </script>";

            echo '
            <!-- Modal de eliminar-->
                <div class="modal fade" id="' . $deleteModal . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $row['id'] . '" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel' . $row['id'] . '">Eliminar ID - ' . $row['id'] . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <p>¿Está seguro de querer eliminar <strong>' . $row['nombre'] . '?</strong></p>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger"><a style="color: white; text-decoration: none"  href="eliminar.php?id=' . $row['id'] . '">Eliminar</a></button>
                      </div>
                    </div>
                  </div>
                </div>';


        }
        echo '</table></div>';
    } else {
        echo '<p>Error al obtener los registros: ' . mysqli_error($conexion) . '</p>';
    }
}
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

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
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
                    <li class="breadcrumb-item">Vinculación</li>
                    <li class="breadcrumb-item">Empresas</li>
                    <li class="breadcrumb-item active" aria-current="page">Giros</li>
                </ol>

                <?php

                    switch ($status) {
                        case 'exito':
                            echo "
                            <div class='alert alert-success  alert-dismissible fade show' role= 'alert'>
                                <i class='fas fa-check'></i> $mensaje
                                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                            </div>";
                            break;
                        case 'error':
                            echo "
                            <div class='alert alert-danger  alert-dismissible fade show' role= 'alert'>
                                <i class='fas fa-exclamation-triangle'></i> $mensaje
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                            break;
                        default:
                            break;
                    }


                ?>
            </nav>
            <hr>

            <div>
                <!--Modal crear un nuevo giro-->
                <div class="modal fade" id="crear-giro-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $row['id'] . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel' . $row['id'] . '">Crear un nuevo giro</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action='crear.php' method='post' class="mx-auto col-md-12 needs-validation" novalidate>
                                    <div class="form-group">
                                        <label for='nombre'>Nombre o razón social</label>
                                        <input required type='text' name='nombre' id='nombre' class="form-control">
                                        <div class="invalid-feedback">
                                            Por favor, ingresar nombre.
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for='descripcion'>Descripción del giro de la empresa</label>
                                        <textarea required name='descripcion' id='descripcion' class="form-control" cols='30' rows='5'></textarea>
                                        <div class="invalid-feedback">
                                            Por favor, ingresar descripción.
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type='submit' class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crear-giro-modal">Nuevo giro</button>
            </div>
            <br>

            <?php getRegistros($conexion); ?>

        </div>
        <?php getFooter() ?>
    </div>
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
