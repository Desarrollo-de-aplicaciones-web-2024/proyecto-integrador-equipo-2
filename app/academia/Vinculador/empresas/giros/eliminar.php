<?php
session_start();
require '../../../../../config/db.php';
$id = $_GET['id'];
$sql_delete = "DELETE FROM giros WHERE id = '$id'";

if (mysqli_query($conexion, $sql_delete)) { //solo checa errores de sintaxis
    if (mysqli_affected_rows($conexion) > 0) { // Verificar si alguna fila fue afectada
       $_SESSION['status'] = 'exito';
        $_SESSION['mensaje'] = 'Registro eliminado con éxito';
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['mensaje'] = 'No se encontró el registro a eliminar';
    }
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Error al eliminar el registro: ' . mysqli_error($conexion);
}

header("Location: index.php");
?>
