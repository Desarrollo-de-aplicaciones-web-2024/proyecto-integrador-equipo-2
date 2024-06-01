<?php
/*Lógica para borrar una convocatoria*/
require '../config/conexion.php';

$convocatoria = $_GET['id'];

$sql = "delete from convocatorias where id= $convocatoria";

$resultado = mysqli_query($conexion,$sql);

if($resultado){
    header('Location: index.php');
}
?>