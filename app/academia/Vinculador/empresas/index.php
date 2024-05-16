<?php
session_start();
require_once '../../../../config/global.php';
require '../../../../config/db.php';
define('RUTA_INCLUDE', '../../../../'); //ajustar a necesidad

$status = isset($_SESSION['status']) ? $_SESSION['status'] : null;
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;

// Limpiar los datos recibidos
unset($_SESSION['status']);
unset($_SESSION['mensaje']);
function getRegistros($conexion) {

    $sql_select = "SELECT empresas.id,empresas.nombre, empresas.email, empresas.telefono, empresas.giro, empresas.ciudad, empresas.direccion, giros.nombre AS nombre_giro from empresas LEFT JOIN giros ON empresas.giro = giros.id;";
    $res = mysqli_query($conexion, $sql_select);

    // Mostrar los registros en una tabla
    if ($res) {
        echo '
          <div class="table-responsive mb-3">
                <table class="table table-bordered dataTable">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Giro</th>
                    <th>Ciudad</th>
                    <th>Direción</th>
                    <th>Acciones</th>
                    
                </tr>';
        while ($row = mysqli_fetch_assoc($res)) {
            $editModal = 'editModal' . $row['id']; // ID único para el modal
            $deleteModal = 'deleteModal' . $row['id']; // ID único para el modal
            // No necesitamos convenios para practias profesionales
            //<th>Vencimiento del convenio</th>
            //<td>' . (empty($row['vencimiento']) ? 'indefinido' : $row['vencimiento']). '</td>
            echo '
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['nombre'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['telefono'] . '</td>
                    <td>' . $row['nombre_giro'] . '</td>
                    <td>' . $row['ciudad'] . '</td>
                    <td>' . $row['direccion'] . '</td>
                    
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
                                    <label for='correo-modal-" . $row['id'] . "' class='col-form-label'>Correo electrónico</label>
                                    <input type='text' required name='correo' class='form-control' id='correo-modal-" . $row['id'] . "' value='" . htmlspecialchars($row['email']) . "'>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                                    <button type='button' class='btn btn-primary' onclick='editar(". $row['id'] . ")'>Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>";

            echo "<script>
                function editar(id) {
                
                    var nombre = document.getElementById('nombre-modal-' + id);
                    var descripcion = document.getElementById('correo-modal-' + id);
                
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
                    <li class="breadcrumb-item active" aria-current="page">Empresas</li>
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
                                <h5 class="modal-title" id="exampleModalLabel' . $row['id'] . '">Registrar empresa</h5>
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
                                            Por favor, ingrese el nombre.
                                        </div>

                                    </div>

                                    <div class='form-group'>
                                        <label for='correo'>Correo electrónico</label>
                                        <input required type="email" name='correo' id='correo' class="form-control" aria-describedby="emailHelp">
                                        <div class="invalid-feedback">
                                            Por favor, ingrese un correo valido.
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for='telefono'>Teléfono de contacto</label>
                                        <input required type="tel" name='telefono' id='telefono' class="form-control"  pattern="^\+?[0-9\s\-\(\)]{10,15}$">
                                        <div class="invalid-feedback">
                                            Por favor, ingrese un telefono valido.
                                        </div>
                                    </div>

                                    <div class='form-group'>
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

                                    <div class='form-group'>
                                        <label for='ciudad'>Ciudad</label>
                                        <select required name='ciudad' id='ciudad' class="custom-select"
                                        >
                                            <option value="">Seleccione una ciudad</option>
                                            <option value="Aguascalientes, Aguascalientes">Aguascalientes, Aguascalientes</option>
                                            <option value="Mexicali, Baja California">Mexicali, Baja California</option>
                                            <option value="La Paz, Baja California Sur">La Paz, Baja California Sur</option>
                                            <option value="Campeche, Campeche">Campeche, Campeche</option>
                                            <option value="Saltillo, Coahuila">Saltillo, Coahuila</option>
                                            <option value="Colima, Colima">Colima, Colima</option>
                                            <option value="Tuxtla Gutiérrez, Chiapas">Tuxtla Gutiérrez, Chiapas</option>
                                            <option value="Chihuahua, Chihuahua">Chihuahua, Chihuahua</option>
                                            <option value="Durango, Durango">Durango, Durango</option>
                                            <option value="Guanajuato, Guanajuato">Guanajuato, Guanajuato</option>
                                            <option value="Acapulco, Guerrero">Acapulco, Guerrero</option>
                                            <option value="Pachuca, Hidalgo">Pachuca, Hidalgo</option>
                                            <option value="Guadalajara, Jalisco">Guadalajara, Jalisco</option>
                                            <option value="Toluca, Estado de México">Toluca, Estado de México</option>
                                            <option value="Morelia, Michoacán">Morelia, Michoacán</option>
                                            <option value="Cuernavaca, Morelos">Cuernavaca, Morelos</option>
                                            <option value="Tepic, Nayarit">Tepic, Nayarit</option>
                                            <option value="Monterrey, Nuevo León">Monterrey, Nuevo León</option>
                                            <option value="Oaxaca, Oaxaca">Oaxaca, Oaxaca</option>
                                            <option value="Puebla, Puebla">Puebla, Puebla</option>
                                            <option value="Querétaro, Querétaro">Querétaro, Querétaro</option>
                                            <option value="Chetumal, Quintana Roo">Chetumal, Quintana Roo</option>
                                            <option value="San Luis Potosí, San Luis Potosí">San Luis Potosí, San Luis Potosí</option>
                                            <option value="Culiacán, Sinaloa">Culiacán, Sinaloa</option>
                                            <option value="Hermosillo, Sonora">Hermosillo, Sonora</option>
                                            <option value="Villahermosa, Tabasco">Villahermosa, Tabasco</option>
                                            <option value="Ciudad Victoria, Tamaulipas">Ciudad Victoria, Tamaulipas</option>
                                            <option value="Tlaxcala, Tlaxcala">Tlaxcala, Tlaxcala</option>
                                            <option value="Xalapa, Veracruz">Xalapa, Veracruz</option>
                                            <option value="Mérida, Yucatán">Mérida, Yucatán</option>
                                            <option value="Zacatecas, Zacatecas">Zacatecas, Zacatecas</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, seleccione una ciudad.
                                        </div>
                                    </div>

                                    <div class='form-group'>
                                        <label for='direccion'>Dirección de la empresa</label>
                                        <input required type='text' name='direccion' id='direccion' class="form-control">
                                        <div class="invalid-feedback">
                                            Por favor, ingrese la dirección
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crear-giro-modal">Nueva empresa</button>
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
