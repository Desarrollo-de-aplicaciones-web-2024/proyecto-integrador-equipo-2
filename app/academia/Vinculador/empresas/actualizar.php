<?php
session_start();
require '../../../../config/db.php';

// Configurar MySQLi para lanzar excepciones
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$giro = $_POST['giro'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];

if (!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($giro) && !empty($ciudad) && !empty($direccion)) {

    if (filter_var($correo,FILTER_VALIDATE_EMAIL) == false) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'Por favor, ingrese un correo electrónico válido.';
        header("Location: index.php");
        exit();
    }

    //ver si el telefono cumple con el patron que le pusimos en el input
    if (!preg_match("/^\+?[0-9\s\-\(\)]{10,15}$/", $telefono)) {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'Por favor, ingrese un número de teléfono válido.';
        header("Location: index.php");
        exit();
    }
    try {
        $sql_delete = "UPDATE `empresas` SET `nombre` = '$nombre', `email` = '$correo', `telefono` = '$telefono', `giro` = '$giro', `ciudad` = '$ciudad', `direccion` = '$direccion' WHERE `empresas`.`id` = '$id'";
        if (!mysqli_query($conexion, $sql_insert)) {
            throw new Exception('No se logró crear el registro');
        }
        if (mysqli_affected_rows($conexion) > 0) { // Verificar si alguna fila fue afectada
            $_SESSION['status'] = 'exito';
            $_SESSION['mensaje'] = 'Registro creado con éxito';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'No se logró crear el registro';
        }
    } catch (mysqli_sql_exception $e) { // Manejar excepciones específicas de MySQL
        if ($e->getCode() == 1062) { // Error 1062: Entrada duplicada
            if (strpos($e->getMessage(), 'email') !== false) {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'Error: El correo electrónico ya existe.';
            } elseif (strpos($e->getMessage(), 'telefono') !== false) {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'Error: El número de teléfono ya existe.';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'Error: Entrada duplicada.';
            }
        } else {
            // Otro error de MySQL
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'Error al crear el registro: ' . $e->getMessage();
        }
    } catch (Exception $e) {
        // Manejar otras excepciones
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = $e->getMessage();
    }

} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Es necesario rellenar todos los campos';
}
header("Location: index.php");