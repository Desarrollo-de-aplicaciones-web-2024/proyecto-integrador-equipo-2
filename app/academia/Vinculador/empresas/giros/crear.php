<?php
session_start();
require '../../../../../config/db.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];


if (!empty($nombre) && !empty($descripcion)){
    try {
        $sql_insert = "INSERT INTO giros (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
        if (mysqli_query($conexion, $sql_insert)) { //solo checa errores de sintaxis
            if (mysqli_affected_rows($conexion) > 0) { // Verificar si alguna fila fue afectada
                $_SESSION['status'] = 'exito';
                $_SESSION['mensaje'] = 'Registro creado con éxito';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['mensaje'] = 'No se logró crear el registro';
            }
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'Error al crear el registro: ' . mysqli_error($conexion);
        }

    } catch (mysqli_sql_exception $e) {
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
