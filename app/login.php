<?php
session_start();
require '../config/db.php';
$matricula = $_POST['matricula'];
$pass = $_POST['pass'];
$error = '';
$strmatri = (string)($matricula);
//QUERY PARA ALUMNOS
$matsql = "SELECT * from alumnos WHERE matricula = '$matricula'";
$stmt = $conexion->prepare($matsql);
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['matricula'] = $row['matricula'];
        $passverif = $row['password'];
    } else {
        $result = '';
    }
    // Cerrar la declaración
    $stmt->close();
}
//QUERY PARA ACADEMICOS
$numesql = "SELECT * from academia WHERE numero_empleado = '$matricula'";
$stmy = $conexion->prepare($numesql);
if ($stmy) {
    $stmy->execute();
    $resulta = $stmy->get_result();
    if ($resulta->num_rows > 0) {
        $row = $resulta->fetch_assoc();
        $_SESSION['numero_empleado'] = $row['numero_empleado'];
        $passverif = $row['password'];
        $puesto = $row ['puesto'];
    } else {
        $resulta = '';
    }
    // Cerrar la declaración
    $stmy->close();
}

if(empty($matricula) || empty($pass)){
 $error = "Llenar todos los campos";
}elseif(!is_numeric($matricula) || $matricula <= 0){
    $error = 'Escriba un valor numérico para la matrícula y que no sea negativo';
}elseif(strlen($strmatri) != 9){
    if(strlen($strmatri) == 5){
        goto a;
    }else{$error = 'La matrícula debe ser de 9 digitios';
    }

}elseif($result == ''){
    $error = 'La matricula seleccionada no existe';
}elseif($pass != $passverif){
    $error = "Contraseña incorrecta";
}else {
    header('Location: alumnos/index.php');
}

a:
if($resulta == ''){
    $error = 'El usuario seleccionado no existe';
}elseif($pass != $passverif){
    $error = "Contraseña incorrecta";
}else {
    switch ($puesto){
        case "admin":
            header('Location: admin/index.php');
            break;
        case "jefe":
            header('Location: academia/Aseguramiento/index.php');
            break;
        case "asegurador":
            header('Location: academia/Aseguramiento/index.php');
            break;
        case "vinculador":
            header('Location: academia/Vinculador/index.php');
            break;
    }
}
if(!empty($error)){
    echo $error;
}