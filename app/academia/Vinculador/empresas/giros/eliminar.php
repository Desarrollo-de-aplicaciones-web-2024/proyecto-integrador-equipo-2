<?php
session_start();
require '../../../../../config/db.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$id = $_GET['id'];


if (!empty($id)){

    try {
        $sql_delete = "DELETE FROM giros WHERE id = '$id'";
        if (!mysqli_query($conexion, $sql_delete)) {
            throw new Exception('No se logró eliminar el registro');
        }

        if (mysqli_affected_rows($conexion) > 0) { // Verificar si alguna fila fue afectada
            $_SESSION['status'] = 'exito';
            $_SESSION['mensaje'] = 'Registro eliminado con éxito';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'No se encontró el registro a eliminar';
        }

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'No se puede elimiar este giro ya que está en uso en registros.';
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
