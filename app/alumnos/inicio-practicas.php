<?php
session_start();
require '../../config/db.php';
require_once '../../config/global.php';
define('RUTA_INCLUDE', '../../');

$mat_alumno = isset($_SESSION['matricula']) ? $_SESSION['matricula'] : null;

if (!$mat_alumno) {
    header('Location: ../index.php');
    exit();
}

//checar si esta en revision
$sql_revision = "select * from practicas WHERE matricula_alumno = '$mat_alumno' AND estatus = 'revision'";
$res = mysqli_query($conexion, $sql_revision);
if ($res && mysqli_num_rows($res) > 0) {
    header('Location: mis-practicas.php');
    exit();
}

//obtener datos del alumno
$sql_alumno = "SELECT a.nombre, a.semestre, p.estatus FROM alumnos a LEFT JOIN practicas p ON a.matricula = p.matricula_alumno WHERE a.matricula = '$mat_alumno';";
$res = mysqli_query($conexion, $sql_alumno);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $nombre = $row['nombre'];
    $semestre = $row['semestre'];
    $practica_status = $row['estatus'];
} else {
    header('Location: ../index.php');
    exit();
}

$status = isset($_SESSION['status']) ? $_SESSION['status'] : null;
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : null;
$empresa = isset($_GET['empresa-id']) ? $_GET['empresa-id'] : null;

$puesto = isset($_GET['puesto']) ? $_GET['puesto'] : null;
$duracion = isset($_GET['duracion']) ? $_GET['duracion'] : null;
$departamento = isset($_GET['departamento']) ? $_GET['departamento'] : null;
$horas = isset($_GET['horas']) ? $_GET['horas'] : null;
$fecha_inicio = isset($_GET['fecha-inicio']) ? $_GET['fecha-inicio'] : null;
$fecha_fin = isset($_GET['fecha-fin']) ? $_GET['fecha-fin'] : null;
$horario_entrada = isset($_GET['horario-inicio']) ? $_GET['horario-inicio'] : null;
$horario_salida = isset($_GET['horario-salida']) ? $_GET['horario-salida'] : null;
$carrera = isset($_GET['carrera']) ? $_GET['carrera'] : null;
$actividades = isset($_GET['actividades']) ? $_GET['actividades'] : null;
$nombre_supervisor = isset($_GET['nombre-supervisor']) ? $_GET['nombre-supervisor'] : null;
$puesto_supervisor = isset($_GET['puesto-supervisor']) ? $_GET['puesto-supervisor'] : null;


$empresa_post = isset($_POST['empresa-id']) ? $_POST['empresa-id'] : null;

//ver si el alumno tiene una practica en estatus pendiente.
$sql_practica = "select * from practicas where matricula_alumno = $mat_alumno and estatus = 'pendiente'";
$res = mysqli_query($conexion, $sql_practica);
if ($res) {
    if (mysqli_num_rows($res) > 0) {
        header("Location: carga-documentos-iniciales.php");
    }
}else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}

// Limpiar los datos recibidos
unset($_SESSION['status']);
unset($_SESSION['mensaje']);

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

//obtenemos a que carreras pertenece el alumno
$carreras_ids = [];
$carreras_alumno = [];
$sql_alumno = "SELECT * FROM carrera_alumno where matricula_alumno = $mat_alumno";
$res = mysqli_query($conexion, $sql_alumno);
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id_carrera = $row["id_carrera"];
        array_push($carreras_ids, $id_carrera);

        // Realizar una consulta para obtener el nombre de la carrera
        $sql_carrera = "SELECT nombre FROM carreras WHERE id = $id_carrera";
        $res_carrera = mysqli_query($conexion, $sql_carrera);

        // Verificar si la consulta fue exitosa
        if ($res_carrera) {
            $row_carrera = mysqli_fetch_assoc($res_carrera);
            $carreras_alumno[$id_carrera] = $row_carrera["nombre"];
        }
    }
} else {
    // Manejo de errores en caso de que la consulta falle
    echo "Error en la consulta: " . mysqli_error($conexion);
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

    <?php getSidebarAlumno('../alumnos/', $semestre, $practica_status); ?>

    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Page Content -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item active" aria-current="page">Inicio de prácticas</li>
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
                <form action="inicio-practicas.php" method="get" novalidate class='needs-validation'>
                    <div class='form-row justify-content-center'>
                        <div class='form-group col-md-3 justify-content-center'>
                            <label for="empresa-id">Nombre o razón social de la empresa</label>
                            <select required class="custom-select" id="empresa-id" name="empresa-id">
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
                        <form method='post' action='guardar_practica.php' novalidate class='needs-validation border border-bottom-0 rounded-top p-4 col-md-11 m-auto'>
                            <fieldset>
                                <legend class='text-center my-3'><h4>Empresa</h4></legend>
                                
                                <div class='form-group col-md-12'>
                                    <div class='form-row justify-content-center'>
                                        <div class='form-group col-md-3'>
                                            <label for='giro-empresa'>Nombre</label>
                                            <input readonly type='text' id='giro-empresa' class='form-control' name='giro-empresa' required value='$nombre_empresa' class='col-md-5'>
                                            <input hidden id='empresa-id' name='empresa-id' required value='$empresa'>
                                        </div>
                                        
                                        <div class='form-group col-md-3'>
                                            <label for='giro-empresa'>Giro de la empresa</label> <br>
                                            <input readonly type='text' id='giro-empresa' class='form-control' name='giro-empresa' required value='$giro_empresa' class='col-md-5'>
                                        </div>
                                        
                                        <div class='form-group col-md-3'>
                                            <label for='email-empresa'>Correo</label> 
                                            <input readonly type='text' id='email-empresa' class='form-control' name='email-empresa' required value='$email_empresa' class='col-md-5'>
                                        </div>
                                        
                                       <div class='form-group col-md-2'>
                                            <label for='telefono-empresa'>Teléfono</label> 
                                            <input readonly type='text' id='telefono-empresa' class='form-control' name='telefono-empresa' required value='$telefono_empresa' class='col-md-5'>
                                        </div>
                                        
                                        <div class='form-group col-md-11'>
                                            <label for='direccion-empresa'>Dirección</label> 
                                            <input readonly type='text' id='direccion-empresa' class='form-control' name='direccion-empresa' required value='$direccion_empresa' class='col-md-5'>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        
                            <div class='dropdown-divider'></div>
                            <fieldset>
                                <legend class='text-center my-3'><h4>Periodo de prácticas</h4></legend>
                                
                                <div class='form-group col-md-12'>
                                    <div class='form-row justify-content-center'>
                                        <div class='form-group col-md-3'>
                                            <label for='puesto-tentativo'>Puesto tentativo a desempeñar</label>
                                            <input required type='text' class='form-control' id='puesto-tentativo' name='puesto-tentativo' value='$puesto'>
                                            <div class='invalid-feedback'>
                                                Puesto requerido
                                            </div>
                                        </div>
                                        <div class='form-group col-md-3'>
                                            <label for='duracion'>Duración de periodo de prácticas</label>
                                            <select required id='duracion' class='form-control custom-select' name='duracion'>
                                            
                                            ";
                                            ?>

                                            <?php
                                                if ($duracion) {
                                                    echo "<option value=''>Meses de prácticas...</option>";
                                                    for ($i = 3; $i <= 12; $i++) {
                                                        if ($duracion == $i) {
                                                            echo "<option value='$i' selected>$i meses</option>";
                                                        } else {
                                                            echo "<option value='$i'>$i meses</option>";
                                                        }
                                                    }
                                                } else {
                                                    echo "<option value='' selected>Meses de prácticas...</option>";
                                                    for ($i = 3; $i <= 12; $i++) {
                                                        echo "<option value='$i'>$i meses</option>";
                                                    }
                                                }
                                            ?>

                                    <?php echo "
                                            </select>
                                            <div class='invalid-feedback'>
                                                Minimo 3 meses
                                            </div>
                                        </div>
                                        <div class='form-group col-md-3'>
                                            <label for='departamento'>Departamento</label>
                                            <input required type='text' class='form-control' id='departamento' placeholder='' name='departamento' value='$departamento'>
                                            <div class='invalid-feedback'>
                                                Departamento requerido
                                            </div>
                                        </div>
                                        <div class='form-group col-md-2'>
                                            <label for='horas'>Horas estimadas</label>
                                            <input required type='number' class='form-control' id='horas' placeholder='Horas' name='horas' value='$horas'>
                                            <div class='invalid-feedback'>
                                                Minimas 240 horas 
                                            </div>
                                        </div>
                                        <div class='form-group col-md-2'>
                                            <label for='fecha-inicio'>Fecha de inicio</label>
                                            <input required type='date' class='form-control' id='fecha-inicio'  name='fecha-inicio' value='$fecha_inicio'>
                                            <div class='invalid-feedback'>
                                                Ingrese una fecha valida
                                            </div>
                                        </div>
                                        <div class='form-group col-md-2'>
                                            <label for='fecha-fin'>Fecha de fin</label>
                                            <input required type='date' class='form-control' id='fecha-fin'  name='fecha-fin' value='$fecha_fin'>
                                            <div class='invalid-feedback'>
                                                Ingrese una fecha valida
                                            </div>
                                        </div>
                                        
                                        <div class='form-group col-md-2'>
                                            <label for='horario-entrada'>Horario entrada</label>
                                            <input required type='time' class='form-control' id='horario-entrada' placeholder='Horario' name='horario-entrada' value='$horario_entrada'>
                                            <div class='invalid-feedback'>
                                                Hora de entrada requerida
                                            </div>
                                        </div>
                                        <div class='form-group col-md-2'>
                                            <label for='horario-salida'>Horario salida</label>
                                            <input required type='time' class='form-control' id='horario-salida' placeholder='Horario' name='horario-salida' value='$horario_salida'>
                                            <div class='invalid-feedback'>
                                                Hora de salida requerida
                                            </div>
                                        </div>
                                        
                                        <div class='form-group col-md-3'>
                                            <label for='carrera'>Carrera</label>
                                            <select required name='carrera' id='carrera' class='form-control custom-select'>
                                            <div class='invalid-feedback'>
                                                Ingrese carrera valida
                                            </div>
                                               ";
                                    ?>

                                    <?php
                                        if ($carrera) {
                                            foreach ($carreras_alumno as $id_carrera => $nombre_carrera) {
                                                if ($carrera == $id_carrera) {
                                                    echo "<option value='$id_carrera' selected>$nombre_carrera</option>";
                                                } else {
                                                    echo "<option value='$id_carrera'>$nombre_carrera</option>";
                                                }
                                            }
                                        } else {
                                            foreach ($carreras_alumno as $id_carrera => $nombre_carrera) {
                                                echo "<option value='$id_carrera'>$nombre_carrera</option>";
                                            }
                                        }
                                    ?>

                                    <?php echo "
                                            </select>
                                        </div>
                                        
                                        <div class='form-group col-md-11'>
                                            <label for='actividades'>Descripción general de actividades a realizar</label>
                                            <textarea required name='actividades' class='form-control' id='actividades' cols='30' rows='2'>$actividades</textarea>
                                            <div class='invalid-feedback'>
                                                Ingrese actividades
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            
                            <div class='dropdown-divider'></div>
                            
                            <fieldset>
                                <legend class='text-center my-3'><h4>Supervisor</h4></legend>
                               <div class='form-group col-md-12'>
                                    <div class='form-row justify-content-center'>
                                        <div class='form-group col-md-3'>
                                            <label for='nombre-supervisor'>Nombre del supervisor</label>
                                            <input required type='text' class='form-control' id='nombre-supervisor' name='nombre-supervisor' value='$nombre_supervisor'>
                                            <div class='invalid-feedback'>
                                                Nombre requerido
                                            </div>
                                        </div>
                                        <div class='form-group col-md-3'>
                                            <label for='puesto-supervisor'>Puesto del supervisor</label>
                                            <input required type='text' class='form-control' id='puesto-supervisor' placeholder='' name='puesto-supervisor' value='$puesto_supervisor'>
                                            <div class='invalid-feedback'>
                                                Puesto requerido
                                            </div>
                                        </div>
                                    </div>
                               </div>
                            </fieldset>
                            
                            <div class='col-md-12 d-flex justify-content-center'>
                                <button type='submit' class='btn btn-primary' onclick='validar()'>Guardar</button>
                            </div>
                        </form>
                    ";

                    echo "
                        <script>
                            function validar(){
                                function clases(elemento,invalid) {
                                    
                                    if (invalid) {
                                        elemento.classList.remove('is-valid');
                                        elemento.classList.add('is-invalid');
                                    } else {
                                        elemento.classList.remove('is-invalid');
                                        elemento.classList.add('is-valid'); 
                                    }
                                }
                                
                                function validarFechaPasada(fecha) {
                                    var fechaActual = new Date();
                                    var fechaIngresada = new Date(fecha);
                                    if (fechaIngresada <= fechaActual) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                                
                                var puesto = document.getElementById('puesto-tentativo');
                                var duracion = document.getElementById('duracion');
                                var departamento = document.getElementById('departamento');
                                var horas = document.getElementById('horas');
                                var fecha_inicio = document.getElementById('fecha-inicio');
                                var fecha_fin = document.getElementById('fecha-fin');
                                var horario_entrada = document.getElementById('horario-entrada');
                                var horario_salida = document.getElementById('horario-salida');
                                var nombre_supervisor = document.getElementById('nombre-supervisor');
                                var puesto_supervisor = document.getElementById('puesto-supervisor');
                                var actividades = document.getElementById('actividades');
                                
                                puesto.value.trim() === '' ? clases(puesto,1) : clases(puesto,0);
                                parseInt(duracion.value) < 3 || duracion.value.trim() === '' ? clases(duracion,1) : clases(duracion,0);
                                departamento.value.trim() === '' ? clases(departamento,1) : clases(departamento,0);
                                parseInt(horas.value) < 240 || horas.value.trim() === '' ? clases(horas,1) : clases(horas,0);
//                                validarFechaPasada(fecha_inicio.value) ? clases(fecha_inicio,1) : clases(fecha_inicio,0);
//                                validarFechaPasada(fecha_fin.value) ? clases(fecha_fin,1) : clases(fecha_fin,0);
                                horario_entrada.value.trim() === '' ? clases(horario_entrada,1) : clases(horario_entrada,0);
                                horario_salida.value.trim() === '' ? clases(horario_salida,1) : clases(horario_salida,0);
                                nombre_supervisor.value.trim() === '' ? clases(nombre_supervisor,1) : clases(nombre_supervisor,0);
                                puesto_supervisor.value.trim() === '' ? clases(puesto_supervisor,1) : clases(puesto_supervisor,0);
                                actividades.value.trim() === '' ? clases(actividades,1) : clases(actividades,0);
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
