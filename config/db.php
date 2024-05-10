<?php
$conexion = mysqli_connect('localhost', 'root', '', '');

if ($conexion === false) { //¿error?
    exit('Error en la conexión con la bd');
}
mysqli_set_charset($conexion, 'utf8');
?>
