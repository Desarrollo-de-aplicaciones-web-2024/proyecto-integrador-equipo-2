<?php
session_start();
require '../../config/db.php';

$editar = $_POST['editar'];
$id_practica = $_POST['practica-id'];

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
$horario_entrada = $_POST['horario-entrada'];
$horario_salida = $_POST['horario-salida'];
$id_carrera = $_POST['carrera'];
$actividades = $_POST['actividades'];




if (!empty($matAlumno) && !empty($id_empresa) && !empty($duracion) && !empty($nombre_supervisor) && !empty($puesto_supervisor) && !empty($fecha_inicio) && !empty($fecha_fin)
    &&!empty($puesto_tentativo) && !empty($departamento) && !empty($horas) && !empty($horario_entrada) && !empty($horario_salida) && !empty($id_carrera) && !empty($actividades)) {


    $fecha_actual = date('Y-m-d');

    // Validar que las fechas no sean pasadas
    if ($fecha_inicio < $fecha_actual) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de inicio no puede ser una fecha pasada.';

        header("Location: inicio-practicas.php?status=error&mensaje=" . urlencode($_SESSION['mensaje']));
        exit();
    } elseif ($fecha_fin < $fecha_actual) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de fin no puede ser una fecha pasada.';
//        header("Location: inicio-practicas.php");
        echo $_SESSION['mensaje'];

    } elseif ($fecha_fin < $fecha_inicio) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
//        header("Location: inicio-practicas.php");
        echo $_SESSION['mensaje'];
    }

//    if ($editar) {
//        $sql_update = "
//            UPDATE practicas
//            SET
//                matricula_alumno = '$matAlumno',
//                estatus = '$status',
//                id_empresa = '$id_empresa',
//                duracion = '$duracion',
//                supervisor = '$nombre_supervisor',
//                puesto_supervisor = '$puesto_supervisor',
//                fecha_inicio = '$fecha_inicio',
//                fecha_fin = '$fecha_fin',
//                puesto = '$puesto_tentativo',
//                departamento = '$departamento',
//                horas = '$horas',
//                horario_entrada = '$horario_entrada',
//                horario_salida = '$horario_salida',
//                id_carrera = '$id_carrera',
//                actividades = '$actividades'
//            WHERE
//                id = '$id_practica'
//        ";
//
//        $res = mysqli_query($conexion, $sql_update);
//
//        if ($res) {
//            $_SESSION['status'] = 'exito';
//            $_SESSION['mensaje'] = 'Datos actualizados correctamente';
//            header("Location: inicio-practicas.php");
//        } else {
//            $_SESSION['status'] = 'error';
//            $_SESSION['mensaje'] = "Error al actualizar los datos: " . mysqli_error($conexion);
//            header("Location: inicio-practicas.php");
//        }
//
//
//
//    } else {
//        try {
//            $sql_insert = "insert into practicas (matricula_alumno,estatus,id_empresa,duracion,supervisor,puesto_supervisor,fecha_inicio,fecha_fin,puesto,departamento,horas,horario_entrada,horario_salida,id_carrera,actividades) values ('$matAlumno','$status','$id_empresa','$duracion','$nombre_supervisor','$puesto_supervisor','$fecha_inicio','$fecha_fin','$puesto_tentativo','$departamento','$horas','$horario_entrada','$horario_salida','$id_carrera','$actividades')";
//            if (!mysqli_query($conexion, $sql_insert)) {
//                throw new Exception('No se logró crear el registro');
//            }
//            if (mysqli_affected_rows($conexion) > 0) { // Verificar si alguna fila fue afectada
//                $ultimo_id = mysqli_insert_id($conexion); // Obtener el ID del último registro insertado
//
//                // Leer la fila que fue creada
//                $query_lectura = "SELECT * FROM practicas WHERE id = $ultimo_id";
//                $resultado_lectura = mysqli_query($conexion, $query_lectura);
//
//                if ($resultado_lectura && mysqli_num_rows($resultado_lectura) > 0) {
//                    $fila_creada = mysqli_fetch_assoc($resultado_lectura);
//                    $_SESSION['fila_creada'] = $fila_creada;
//                    $_SESSION['status'] = 'exito';
//                    $_SESSION['mensaje'] = 'Registro creado con éxito: ' . json_encode($fila_creada);
//                    header("Location: carga-documentos-iniciales.php");
//
//                } else {
//                    $_SESSION['status'] = 'error';
//                    $_SESSION['mensaje'] = 'No se pudo leer el registro creado';
//                    header("Location: inicio-practicas.php");
//                }
//            } else {
//                $_SESSION['status'] = 'error';
//                $_SESSION['mensaje'] = 'No se logró crear el registro';
//                header("Location: inicio-practicas.php");
//            }
//        }  catch (Exception $e) {
//            // Manejar otras excepciones
//            $_SESSION['status'] = 'error';
//            $_SESSION['mensaje'] = $e->getMessage();
//            header("Location: inicio-practicas.php");
//        }
//    }
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Es necesario rellenar todos los campos';
    header("Location: inicio-practicas.php");
}


