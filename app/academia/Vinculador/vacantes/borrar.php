<?php
/*Lógica para borrar una convocatoria*/
session_start();
require '../../../../config/db.php';

$convocatoria = $_GET['id'];

$sql = "delete from convocatorias where id= $convocatoria";
$resultado = mysqli_query($conexion,$sql);
if($resultado){
    $_SESSION['status'] = 'exito';
    $_SESSION['mensaje'] = 'Convocatoria eliminada con exito';
    header('Location: index.php');
}
?>