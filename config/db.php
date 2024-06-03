<?php
$conexion = mysqli_connect('sistema-practicas.cluster-c7y2igeuk57s.us-east-2.rds.amazonaws.com', 'koda', '134acbe03e045066df8ca596126f14a5', 'sistema_practicas',3306);

if ($conexion === false) { //¿error?
    exit('Error en la conexión con la bd');
}
mysqli_set_charset($conexion, 'utf8');
?>
