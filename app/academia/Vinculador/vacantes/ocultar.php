<?php
session_start();
require '../../../../config/db.php';

$convocatoria = $_POST['id'];
$ocultar = $_POST['ocultar'] ?? 0;



$ocultar = !$ocultar == 'on' ? 1 : 0;

//echo $ocultar;
//exit();


$sql = "UPDATE convocatorias SET visible = $ocultar WHERE id = $convocatoria";

// Ejecutar la consulta
if (mysqli_query($conexion, $sql)) {
    $_SESSION['status'] = 'exito';
    $_SESSION['mensaje'] = 'Convocatoria actualizada';
    header('Location: index.php');
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['mensaje'] = 'Error al actualizar la convocatoria';
    header('Location: index.php');
}
