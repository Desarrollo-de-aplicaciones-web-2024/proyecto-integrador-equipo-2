<?php
session_start();
require '../../../../../config/db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];


if (!empty($nombre) && !empty($descripcion)){

    try {
        $sql_actualizar = "UPDATE `giros` SET `nombre` = '$nombre', `descripcion` = '$descripcion' WHERE id = '$id'";

        if (mysqli_query($conexion, $sql_actualizar)) { //solo checa errores de sintaxis
            if (mysqli_affected_rows($conexion) > 0) { // Verificar si alguna fila fue afectada
                $_SESSION['status'] = 'exito';
                $_SESSION['mensaje'] = 'Registro actualizado con éxito';
            }
            //    else {
            //        $_SESSION['status'] = 'error';
            //        $_SESSION['mensaje'] = 'No se encontró el registro a actualizar';
            //    }
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'Error al actualizar el registro: ' . mysqli_error($conexion);
        }

    } catch (mysqli_sql_exception $e){
        if ($e->getCode() == 1062) { // Error 1062: Entrada duplicada
            if (strpos($e->getMessage(), 'nombre') !== false) {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'Ya hay un giro con el nombre ' . $nombre;
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'Error: Entrada duplicada.';
            }
        } else {
            // Otro error de MySQL
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'Error al crear el registro: ' . $e->getMessage();
        }
    }

} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Es necesario rellenar todos los campos';
}
header("Location: index.php");
?>
