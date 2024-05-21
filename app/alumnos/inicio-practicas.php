<?php
session_start();
require '../../config/db.php';
require_once '../../config/global.php';
define('RUTA_INCLUDE', '../../'); //ajustar a necesidad

//Esta pantalla es para regisrtrar que el alumno ya haya seleccionado la empresa y los datos.
//En la siguiente pantalla se generan y cargan los documentos en PDF.
//El alumno puede volver a esta pantalla desde la siguiente.
//Se valida que el alumno ya tengo un registro de practicas


$status = isset($_SESSION['status']) ? $_SESSION['status'] : null;
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;

// Limpiar los datos recibidos
unset($_SESSION['status']);
unset($_SESSION['mensaje']);

$empresa = isset($_POST['empresa-id']) ? $_POST['empresa-id'] : null;


if (!empty($empresa)){
    $sql_empresa = "SELECT empresas.id,empresas.nombre, empresas.email, empresas.telefono, empresas.giro, empresas.ciudad, empresas.direccion, giros.nombre AS nombre_giro from empresas LEFT JOIN giros ON empresas.giro = giros.id WHERE empresas.id = '$empresa'";
    $res = mysqli_query($conexion, $sql_empresa); //puede que se le pase un id que no existe o algo asi

    while ($row = mysqli_fetch_assoc($res)) {
        $nombre_empresa = $row['nombre'];
        $giro_empresa = $row['nombre_giro'];
        $email_empresa = $row['email'];
        $telefono_empresa = $row['telefono'];
        $direccion_empresa = $row['direccion'];
        $ciudad_empresa = $row['ciudad'];

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


    <?php getTopIncludes(RUTA_INCLUDE ) ?>

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
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item active" aria-current="page">Documentación inicial</li>
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
                <form action="inicio-practicas.php" method="post" novalidate class='needs-validation JUST'>
                    <div class='form-row justify-content-center'>
                        <div class='form-group col-md-3 justify-content-center'>
                            <label for="empresa-id">Nombre o razón social de la empresa</label>
                            <select required class="custom-select" id="empresa-id" name="empresa-id" onchange="getEmpresa()">
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
                        </div>
                        <div class="form-group align-self-end">
                            <button  type="submit" class="btn btn-primary">Seleccionar</button>
                        </div>
                    </div>

                </form>




            <?php

                if ($empresa) {
                    echo "
                        <form method='post' action='guardar_practica.php' novalidate class='needs-validation'>
                        
                        
                            <div class='col'>
                                <div class='form-group col-md-6'>
                                    <label for='giro-empresa'>Giro de la empresa</label> 
                                    <input readonly type='text' id='giro-empresa' name='giro-empresa' required value='$giro_empresa' class='col-md-5'>
                                    <input hidden id='empresa-id' name='empresa-id' required value='$empresa'>
                                    
                                </div>
                                
                                <div class='form-group col-md-6'>
                                    <label for='direccion-empresa'>Dirección</label> 
                                    <input readonly type='text' id='direccion-empresa' name='direccion-empresa' required value='$direccion_empresa' class='col-md-5'>
                                </div>
                                
                                <div class='form-group col-md-6'>
                                    <label for='email-empresa'>Correo</label> 
                                    <input readonly type='text' id='email-empresa' name='email-empresa' required value='$email_empresa' class='col-md-5'>
                                </div>
                                
                                <div class='form-group col-md-3'>
                                    <label for='telefono-empresa'>Teléfono</label> 
                                    <input readonly type='text' id='telefono-empresa' name='telefono-empresa' required value='$telefono_empresa' class='col-md-5'>
                                </div>
                             </div>

                            
                            <div class='form-group col-md-12'>
                                <div class='form-row'>
                                    <div class='form-group col-md-3'>
                                        <label for='puesto-tentativo'>Puesto tentativo a desempeñar</label>
                                        <input required type='text' class='form-control' id='puesto-tentativo' name='puesto-tentativo'>
                                    </div>
                                    <div class='form-group col-md-2'>
                                        <label for='duracion'>Duración de periodo de prácticas</label>
                                        <select required id='duracion' class='form-control custom-select' name='duracion'>
                                            <option value='' selected>Selecciona...</option>
                                            <option value='1'>1 mes</option>
                                            <option value='2'>2 meses</option>
                                            <option value='3'>3 meses</option>
                                            <option value='4'>4 meses</option>
                                            <option value='5'>5 meses</option>
                                            <option value='6'>6 meses</option>
                                            <option value='7'>7 meses</option>
                                            <option value='8'>8 meses</option>
                                            <option value='9'>9 meses</option>
                                            <option value='10'>10 meses</option>
                                            <option value='11'>11 meses</option>
                                            <option value='12'>12 meses</option>
                                        </select>
                                    </div>
                                    <div class='form-group col-md-3'>
                                        <label for='departamento'>Departamento</label>
                                        <input required type='text' class='form-control' id='departamento' placeholder='Departamento en el que te vas a quedar' name='departamento'>
                                    </div>
                                    <div class='form-group col-md-1'>
                                        <label for='horas'>Horas estimadas</label>
                                        <input required type='number' class='form-control' id='horas' placeholder='Horas' name='horas'>
                                    </div>
                                    <div class='form-group col-md-1.5'>
                                        <label for='fecha-inicio'>Fecha de inicio</label>
                                        <input required type='date' class='form-control' id='fecha-inicio' placeholder='Horas' name='fecha-inicio'>
                                    </div>
                                    <div class='form-group col-md-1.5'>
                                        <label for='fecha-fin'>Fecha de fin</label>
                                        <input required type='date' class='form-control' id='fecha-fin' placeholder='Horas' name='fecha-fin'>
                                    </div>
                                </div>
                            </div>
                            
                            <div class='form-group col-md-12'>
                                <div class='form-row'>
                                    <div class='form-group col-md-3'>
                                        <label for='nombre-supervisor'>Nombre del supervisor</label>
                                        <input required type='text' class='form-control' id='nombre-supervisor' name='nombre-supervisor'>
                                    </div>
                                    <div class='form-group col-md-3'>
                                        <label for='puesto-supervisor'>Puesto del supervisor</label>
                                        <input required type='text' class='form-control' id='puesto-supervisor' placeholder='' name='puesto-supervisor'>
                                    </div>
                                </div>
                            </div>
                            <button type='submit' class='btn btn-primary' onclick='validar()'>Guardar</button>
                        </form>
                    ";

                    echo "
                        <script>
                        
                            function validar(){
                                var puesto = document.getElementById('puesto-tentativo').value;
                                var duracion = document.getElementById('duracion').value;
                                var departamento = document.getElementById('departamento').value;
                                var duracion = document.getElementById('duracion').value;
                                var fecha_inicio = document.getElementById('fecha-inicio').value;
                                
                                console.log(fecha_inicio);
                            }
                        </script>
                    ";
                }

            ?>

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
