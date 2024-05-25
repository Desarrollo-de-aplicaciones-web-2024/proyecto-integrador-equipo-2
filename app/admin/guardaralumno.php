<?php
require '../../config/db.php';
$matricula = $_POST['matricula'];
$nombre  = $_POST['nombre'];
$sexo = $_POST['sexo'];
$semestre = $_POST['semestre'];
$password = $_POST['password'];
$carrera = $_POST['carrera'];
$error = '';
$strmatri = (string)($matricula);

$carrsql = "SELECT id from carreras WHERE nombre = '$carrera'";
$stmt = $conexion->prepare($carrsql);
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Guardar el ID en una variable
        $carrera_id = $row['id'];
    } else {
        $result = '';
    }
    // Cerrar la declaración
    $stmt->close();
}


if(empty($matricula) || empty($nombre) || empty($sexo) || empty($semestre) || empty($password) || empty($carrera)){
    $error =  'Error, datos obligatorios no establecidos';
}elseif(!is_numeric($matricula) || $matricula <= 0){
    $error = 'Escriba un valor numérico para la matrícula y que no sea negativo';
}elseif(strlen($strmatri) != 9){
    $error = 'La matrícula debe ser de 9 digitios';
}elseif(preg_match('/[0123456789]/', $nombre)){
    $error = 'El nombre del alumno no puede tener números';
}elseif($sexo != 'H' && $sexo != 'M'){
    $error = 'El sexo sólo puede ser Masculino o Femenino';
}elseif($semestre > 10 || $semestre < 4){
    $error = 'El semestre en curso para las prácticas debe ser entre 4to y 10mo';
}elseif($result == ''){
    $error = 'La carrera seleccionada no existe';
}else{
$sql ="insert into alumnos (matricula, nombre, sexo, semestre, password) values ('$matricula','$nombre','$sexo','$semestre','$password')";
$sql2 = "insert into carrera_alumno (matricula_alumno, id_carrera) values ('$matricula','$carrera_id')";
    $resultado = mysqli_query($conexion, $sql);
$stmt = $conexion->prepare($sql2);
if ($stmt) {
    $stmt->execute();
}
    if($resultado){
        header('Location: registroalumno.php');
    }
}

if(!empty($error)){
    echo $error;
}

?>
