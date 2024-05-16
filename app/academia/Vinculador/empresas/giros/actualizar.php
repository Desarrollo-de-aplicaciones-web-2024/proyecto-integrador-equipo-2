<?php
session_start();
require '../../../../../config/db.php';
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];


if (!empty($nombre) && !empty($descripcion)){

    $sql_delete = "UPDATE `giros` SET `nombre` = '$nombre', `descripcion` = '$descripcion' WHERE id = '$id'";

    if (mysqli_query($conexion, $sql_delete)) { //solo checa errores de sintaxis
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

} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Es necesario rellenar todos los campos';
}



header("Location: index.php");
?>
