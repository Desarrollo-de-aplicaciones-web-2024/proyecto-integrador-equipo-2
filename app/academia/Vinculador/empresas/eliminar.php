<?php
session_start();
require '../../../../config/db.php';
$id = $_GET['id'];
$sql_delete = "DELETE FROM empresas WHERE id = '$id'";


if (!empty($id)){
    try {
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
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'No se puede elimiar este giro ya que está en uso en otros registros.';
        } else {
            // Otro error de MySQL
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'Error al eliminar el registro: ' . $e->getMessage();
        }
    }

} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Registro no especificado';
}


header("Location: index.php");
?>
