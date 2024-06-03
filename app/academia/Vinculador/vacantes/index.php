<?php
session_start();
require_once '../../../../config/global.php';
require '../../../../config/db.php';
define('RUTA_INCLUDE', '../../../../'); //ajustar a necesidad


$status = $_SESSION['status'] ?? null;
$mensaje = $_SESSION['mensaje'] ?? null;

// Limpiar los datos recibidos
unset($_SESSION['status']);
unset($_SESSION['mensaje']);
function getRegistros($conexion) {
    $sql_vacantes = "SELECT convocatorias.id AS id_convocatoria, empresas.id AS id_empresa, convocatorias.visible, convocatorias.titulo, convocatorias.descripcion, convocatorias.imagen, convocatorias.fecha_limite, convocatorias.vacantes, empresas.nombre, empresas.email, empresas.telefono FROM convocatorias JOIN empresas ON convocatorias.id_empresa = empresas.id;";
    $res = mysqli_query($conexion, $sql_vacantes);

    // Mostrar los registros en una tabla
    if ($res) {
        echo '
          <div class="table-responsive mb-3">
                <table class="table table-bordered dataTable">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>titulo</th>
                    <th>Contacto</th>
                    <th>Vacantes</th>
                    <th>Fecha limite</th>
                    <th>Acciones</th>
                    
                </tr>
                  </thead>
                ';
        while ($row = mysqli_fetch_assoc($res)) {
            $editModal = 'editModal' . $row['id_convocatoria']; // ID único para el modal
            $deleteModal = 'deleteModal' . $row['id_convocatoria'];
            $visibleModal = 'visibleModal' . $row['id_convocatoria'];

            $titulo = $row['titulo'];
            $limite = $row['fecha_limite'];
            $correo = "Email: " . $row['email'];
            $tel = "Tel: " . $row['telefono'];
            $descripcion = $row['descripcion'];
            $vacantes = $row['vacantes'];
            $nombre_empresa = $row['nombre'];

            $id_vacante = $row['id_convocatoria'];

            $fondo = $row['visible'] ? "" : "background:#ECECEC;";

            $ocultarBtn = $row['visible'] ? "fas fa-eye text-secondary" : "fas fa-eye-slash text-secondary";
            $ocultarTitle = $row['visible'] ? "Ocultar" : "Mostrar";

            echo '
                <tr style='.$fondo.'>
                    <td>' . $nombre_empresa . '</td>
                    <td>' . $titulo . '</td>
                    <td>' . $correo . ' <br> ' . $tel . ' </td>
                    <td>' . ($vacantes == 0 ? 'Indefinido' : $vacantes) . '</td>
                    <td>' . ($row['fecha_limite'] === "0000-00-00" ? 'Indefinido' : $row['fecha_limite']) . '</td>
                    
                    <td>
                        <i title="editar" type="button" class="fa fa-edit text-primary" data-toggle="modal" data-target="#' . $editModal . '"></i>
                        <i title="'.$ocultarTitle.'" type="button" class="'.$ocultarBtn.'" data-toggle="modal" data-target="#' . $visibleModal . '"></i>
                        <i title="eliminar" type="button" class="fas fa-trash text-danger" data-toggle="modal" data-target="#' . $deleteModal . '"></i>
                    </td>
                </tr>';

            echo "
            <!-- Modal de edición-->
            <div class='modal fade' id='" . $editModal . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel" . $row['id_convocatoria'] . "' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel" . $row['id_convocatoria'] . "'>Editar - " . $titulo . "</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <form action='editar.php' method='post' class='needs-validation' novalidate enctype='multipart/form-data'>
                                    <div class='form-group'>
                                        <label for='titulo'>Titulo de la vacante</label>
                                        <input type='hidden' value='$id_vacante' name='id_vacante' id='id_vacante'>
                                        <input required type='text' name='titulo' id='titulo' class='form-control' value='$titulo'>
                                        <div class='invalid-feedback'>
                                            Titulo requerido
                                        </div>
                                    </div>
                                
                                <div class='form-group'>
                                    <label for='empresa-id'>Empresa</label>
                                    <select  required class='custom-select' id='empresa-id" . $row['id_empresa'] . "' name='empresa-id'>
                                        
                                        ";

            $sql_empresas_select = "SELECT id,nombre FROM empresas";
            $res_empresas = mysqli_query($conexion, $sql_empresas_select);
            if ($res_empresas) {
                while ($row_empresa = mysqli_fetch_assoc($res_empresas)) {
                    if ($row_empresa['id'] === $row['id_empresa']) {
                        echo '<option selected value=' . $row_empresa['id'] . '>' . $row_empresa['nombre'] . '</option>';
                    }
                    echo '<option value=' . $row_empresa['id'] . '>' . $row_empresa['nombre'] . '</option>';
                }
            }

            echo "
                                    </select>
                                    <div class='invalid-feedback'>
                                        Empresa requerida
                                    </div>
                                </div>
                                
                                <div class='form-group'>
                                        <label for='descripcion'>Descripción</label>
                                        <textarea required name='descripcion' id='descripcion' cols='40' rows='3' class='form-control'>$descripcion</textarea>
                                        <div class='invalid-feedback'>
                                            Descripción requerida
                                        </div>
                                </div>
                                    
                            
                                <div class='form-group'>
                                    <div class='custom-file'>
                                        <input type='file' class='custom-file-input' id='imagen' name='imagen'>
                                        <label class='custom-file-label' for='imagen'>Banner de la vacante</label>
                                        <div class='invalid-feedback'>
                                            Imagen requerida
                                        </div>
                                        <p id='banner-name'></p>
                                    </div>
                                </div>
                                
                                <div class='form-group'>
                                    <label for='inputCantidadVacantes'>Vacantes disponibles</label>
                                    <select class='custom-select' id='inputCantidadVacantes' name='vacantes'>
                                    ";

            if ($vacantes == 0) {
                echo "<option selected value=''>Indefinida</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>";
            } else {
                echo "<option selected value=''>Indefinida</option>";
                for ($i = 1; $i <= 5; $i++) {
                    if ($i == $vacantes) {
                        echo "<option selected value='$vacantes'>$vacantes</option>";
                    } else {
                        echo "<option value='$i'>$i</option>";
                    }
                }
            }

            echo "
                                    </select>
                                </div>
                                
                                <div class='form-group'>
                                    <label for='fecha-limite'>Fecha limite (Opcional)</label>
                                    <input type='date' name='fecha-limite' id='fecha-limite' class='form-control' value='$limite'>
                                </div>

                                        
                                
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                                    <button type='submit' class='btn btn-primary'>Guardar</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                
            ";

            echo '
            <!-- Modal de eliminar-->
                <div class="modal fade" id="' . $deleteModal . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $row['id_convocatoria'] . '" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel' . $row['id_convocatoria'] . '">Eliminar - ' . $row['titulo'] . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="form-group">
                            <input type="hidden" name="id" value="' . $id_vacante .'">
                            <p>¿Está seguro de querer eliminar <strong>' . $row['titulo'] . '?</strong></p>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger"><a style="color: white; text-decoration: none"  href="borrar.php?id=' . $row['id_convocatoria'] . '">Eliminar</a></button>
                      </div>
                    </div>
                  </div>
                </div>';

            echo '
            <!-- Modal de ocultar-->
                <div class="modal fade" id="' . $visibleModal . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $row['id_convocatoria'] . '" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel' . $row['id_convocatoria'] . '">Ocultar - ' . $row['titulo'] . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="ocultar.php" method="post">
                          <div class="form-group">
                                <input type="hidden" name="id" value="'.$id_vacante.'">
                                <label class="switch">';

                                if ($row['visible'] == 1){
                                    echo "<input name='ocultar' type='checkbox' id='statusCheckbox'>";
                                } else {
                                    echo "<input name='ocultar' checked type='checkbox' id='statusCheckbox'>";
                                }

                         echo '
                                    
                                    <span class="slider round"></span>
                                </label>
                              <style>
                              /* The switch - the box around the slider */
                                .switch {
                                  position: relative;
                                  display: inline-block;
                                  width: 60px;
                                  height: 34px;
                                }
                                
                                /* Hide default HTML checkbox */
                                .switch input {
                                  opacity: 0;
                                  width: 0;
                                  height: 0;
                                }
                                
                                /* The slider */
                                .slider {
                                  position: absolute;
                                  cursor: pointer;
                                  top: 0;
                                  left: 0;
                                  right: 0;
                                  bottom: 0;
                                  background-color: #ccc;
                                  -webkit-transition: .4s;
                                  transition: .4s;
                                }
                                
                                .slider:before {
                                  position: absolute;
                                  content: "";
                                  height: 26px;
                                  width: 26px;
                                  left: 4px;
                                  bottom: 4px;
                                  background-color: white;
                                  -webkit-transition: .4s;
                                  transition: .4s;
                                }
                                
                                input:checked + .slider {
                                  background-color: #545b62;
                                }
                                
                                input:focus + .slider {
                                  box-shadow: 0 0 1px #2196F3;
                                }
                                
                                input:checked + .slider:before {
                                  -webkit-transform: translateX(26px);
                                  -ms-transform: translateX(26px);
                                  transform: translateX(26px);
                                }
                                
                                /* Rounded sliders */
                                .slider.round {
                                  border-radius: 34px;
                                }
                                
                                .slider.round:before {
                                  border-radius: 50%;
                                }
                                </style>
                            </label>
                          </div>
                          
                          </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>
                        </form>
                      
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

        document.addEventListener('DOMContentLoaded', function () {
            var inputs = document.querySelectorAll('.custom-file-input');
            Array.prototype.forEach.call(inputs, function (input) {
                input.addEventListener('change', function (e) {
                    var fileName = input.files[0].name;
                    var label = document.getElementById('banner-name');
                    label.innerHTML = fileName;
                });
            });
        });

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

    <ul class="sidebar navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="../../dashboard/metricas.php">
                <i class="fas fa-calculator"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../dashboard/documentosPendientes.php">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Documentos pendientes</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../empresas/index.php">
                <i class="fas fa-fw fa-building"></i>
                <span>Empresas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="fas fa-dollar-sign"></i>
                <span>Vacantes</span>
            </a>
        </li>
    </ul>


    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Page Content -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Vinculación</li>
                    <li class="breadcrumb-item active" aria-current="page">Vacantes</li>
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
                <div class="modal fade" id="crear-convocatoria-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel' . $row['id'] . '" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel' . $row['id'] . '">Nueva vacante</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action='nueva.php' method='post' class="mx-auto col-md-12 needs-validation" novalidate enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for='titulo'>Titulo de la vacante</label>
                                        <input required type='text' name='titulo' id='titulo' class="form-control">
                                        <div class="invalid-feedback">
                                            Titulo requerido
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for="empresa">Empresa</label>
                                        <select  required class="custom-select" id="empresa" name="empresa-id">
                                            <option selected value="">Seleccione una empresa...</option>
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
                                            Empresa requerida
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for='descripcion'>Descripción</label>
                                        <textarea required name="descripcion" id="descripcion" cols="30" rows="3" class="form-control"></textarea>
                                        <div class="invalid-feedback">
                                            Descripción requerida
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="imagen" name="imagen">
                                            <label class="custom-file-label" for="imagen">Banner de la vacante</label>
                                            <div class="invalid-feedback">
                                                Imagen requerida
                                            </div>
                                            <p id="banner-name"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputCantidadVacantes">Vacantes disponibles</label>
                                        <select class="custom-select" id="inputCantidadVacantes" name="vacantes">
                                            <option selected value="">Indefinida</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for='fecha-limite'>Fecha limite (Opcional)</label>
                                        <input type='date' name='fecha-limite' id='fecha-limite' class="form-control">
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crear-convocatoria-modal">Nueva vacante</button>
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
