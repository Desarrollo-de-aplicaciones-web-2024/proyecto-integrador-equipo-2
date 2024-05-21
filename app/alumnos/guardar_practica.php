<?php
session_start();
require '../../config/db.php';

$matAlumno = '202160023'; //matricula del usuario qeu esta logeado en el sistema
$status = 'pendiente';
$id_empresa =$_POST['empresa-id'];
$duracion = $_POST['duracion'];
$nombre_supervisor = $_POST['nombre-supervisor'];
$puesto_supervisor = $_POST['puesto-supervisor'];
$fecha_inicio = $_POST['fecha-inicio'];
$fecha_fin = $_POST['fecha-fin'];
$puesto_tentativo = $_POST['puesto-tentativo'];
$departamento = $_POST['departamento'];
$horas = $_POST['horas'];


if (!empty($matAlumno) && !empty($id_empresa) && !empty($duracion) && !empty($nombre_supervisor) && !empty($puesto_supervisor) && !empty($fecha_inicio) && !empty($fecha_fin)
    &&!empty($puesto_tentativo) && !empty($departamento) && !empty($horas)){


    try {
        $sql_insert = "insert into practicas (matricula_alumno,estatus,id_empresa,duracion,supervisor,puesto_supervisor,fecha_inicio,fecha_fin,puesto,departamento,horas) values ('$matAlumno','$status','$id_empresa','$duracion','$nombre_supervisor','$puesto_supervisor','$fecha_inicio','$fecha_fin','$puesto_tentativo','$departamento','$horas')";
        if (!mysqli_query($conexion, $sql_insert)) {
            throw new Exception('No se logró crear el registro');
        }
        if (mysqli_affected_rows($conexion) > 0) { // Verificar si alguna fila fue afectada
            $ultimo_id = mysqli_insert_id($conexion); // Obtener el ID del último registro insertado

            // Leer la fila que fue creada
            $query_lectura = "SELECT * FROM practicas WHERE id = $ultimo_id";
            $resultado_lectura = mysqli_query($conexion, $query_lectura);

            if ($resultado_lectura && mysqli_num_rows($resultado_lectura) > 0) {
                $fila_creada = mysqli_fetch_assoc($resultado_lectura);
                $_SESSION['fila_creada'] = $fila_creada;
                $_SESSION['status'] = 'exito';
                $_SESSION['mensaje'] = 'Registro creado con éxito: ' . json_encode($fila_creada);
                header("Location: carga-documentos-iniciales.php");

            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'No se pudo leer el registro creado';
                header("Location: inicio-practicas.php");
            }
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'No se logró crear el registro';
            header("Location: inicio-practicas.php");
        }
    }  catch (Exception $e) {
        // Manejar otras excepciones
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = $e->getMessage();
        header("Location: inicio-practicas.php");
    }

//    echo "
//    <p>$matAlumno</p>
//    <p>$status</p>
//    <p>$id_empresa</p>
//    <p>$duracion</p>
//    <p>$nombre_supervisor</p>
//    <p>$puesto_supervisor</p>
//    <p>$fecha_inicio</p>
//    <p>$fecha_fin</p>
//    <p>$puesto_tentativo</p>
//    <p>$departamento</p>
//    <p>$horas</p>
//";
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Es necesario rellenar todos los campos';
    header("Location: inicio-practicas.php");
}


