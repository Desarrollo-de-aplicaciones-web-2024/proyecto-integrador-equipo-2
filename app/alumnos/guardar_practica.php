<?php
session_start();
require '../../config/db.php';

$id_practica = $_POST['practica-id'] ?? null;
$editar = $_POST['editar'] ?? null;
$matAlumno = $_SESSION['matricula'];
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

    $query_params = http_build_query(array(
        'practica-id' => $id_practica,
        'empresa-id' => $id_empresa,
        'puesto' => $puesto_tentativo,
        'duracion' => $duracion,
        'departamento' => $departamento,
        'horas' => $horas,
        'fecha-inicio' => $fecha_inicio,
        'fecha-fin' => $fecha_fin,
        'horario-inicio' => $horario_entrada,
        'horario-salida' => $horario_salida,
        'carrera' => $id_carrera,
        'actividades' => $actividades,
        'nombre-supervisor' => $nombre_supervisor,
        'puesto-supervisor' => $puesto_supervisor
    ));

    $fecha_actual = date('Y-m-d');

    $Location = $editar ? "Location: editar-practica.php?" . $query_params : "Location: inicio-practicas.php?" . $query_params;

    //validar que el usuario pertenezca a la carreara que ingresó
    $sql_select_carreras = "select * from carrera_alumno WHERE matricula_alumno = '$matAlumno'";
    $res = mysqli_query($conexion, $sql_select_carreras);
    $coincide = false;
    while ($row = mysqli_fetch_assoc($res)) {
        if($id_carrera === $row['id_carrera']){
            $coincide = true;
        }
    }
    if (!$coincide) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'El alumno no pertence a la carrear ingresa.' . $id_carrera;
        header($Location);
        exit();
    }

    if ($fecha_inicio < $fecha_actual) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de inicio no puede ser una fecha pasada.';
        header($Location);
        exit();
    }

    if ($fecha_fin < $fecha_actual) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de fin no puede ser una fecha pasada.';
        header($Location);
        exit();
    }

    if ($fecha_fin === $fecha_inicio) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de inicio no puede ser igual a la fecha de fin.';
        header($Location);
        exit();
    }

    if ($fecha_fin < $fecha_inicio) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
        header($Location);
        exit();
    }

    $fecha_inicio_dt = new DateTime($fecha_inicio);
    $fecha_fin_dt = new DateTime($fecha_fin);
    $fecha_esperada_dt = clone $fecha_inicio_dt;
    $fecha_esperada_dt->modify("+{$duracion} months");


    if ($fecha_fin_dt < $fecha_esperada_dt) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'La fecha de fin debe de coincidir con la duración.';
        header($Location);
        exit();
    }

    if($horas < 240) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'El minimo de horas requeridas son 240';
        header($Location);
        exit();
    }

    if($duracion < 3) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'El periodo de prácticas no puede ser menor a 3 meses.';
        header($Location);
        exit();
    }

    if ($editar) {

        try {
            $sql_update = "UPDATE practicas 
               SET id_empresa = '$id_empresa',
                   duracion = '$duracion',
                   supervisor = '$nombre_supervisor',
                   puesto_supervisor = '$puesto_supervisor',
                   fecha_inicio = '$fecha_inicio',
                   fecha_fin = '$fecha_fin',
                   puesto = '$puesto_tentativo',
                   departamento = '$departamento',
                   horas = '$horas',
                   horario_entrada = '$horario_entrada',
                   horario_salida = '$horario_salida',
                   id_carrera = '$id_carrera',
                   actividades = '$actividades'
               WHERE id = '$id_practica'";
            if (!mysqli_query($conexion, $sql_update)) {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'No se pudo actualizar la práctica.';
                header($Location);
                exit();
            }

            $_SESSION['status'] = 'exito';
            $_SESSION['mensaje'] = 'Datos guardados';
            header("Location: carga-documentos-iniciales.php");


        } catch (Exception $e) {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = $e->getMessage();
            header($Location);
        }

    } else {
        try {
            echo "no tan rapido";
            $sql_insert = "insert into practicas (matricula_alumno,estatus,id_empresa,duracion,supervisor,puesto_supervisor,fecha_inicio,fecha_fin,puesto,departamento,horas,horario_entrada,horario_salida,id_carrera,actividades) values ('$matAlumno','$status','$id_empresa','$duracion','$nombre_supervisor','$puesto_supervisor','$fecha_inicio','$fecha_fin','$puesto_tentativo','$departamento','$horas','$horario_entrada','$horario_salida','$id_carrera','$actividades')";
            if (!mysqli_query($conexion, $sql_insert)) {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'No se logró crear el registro';
                header("Location: inicio-practicas.php?" . $query_params);
            }
            if (mysqli_affected_rows($conexion) > 0) {
                $_SESSION['status'] = 'exito';
                $_SESSION['mensaje'] = 'Datos guardados';
                header("Location: carga-documentos-iniciales.php");
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
    }



} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Es necesario rellenar todos los campos';
    $Location = $editar ? "Location: editar-practica.php?" : "Location: inicio-practicas?";
    header($Location);
}


