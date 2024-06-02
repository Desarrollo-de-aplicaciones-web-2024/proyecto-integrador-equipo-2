<?php
require '../config/db.php';
$matricula = $_POST['matricula'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
if($password != $password2){
    echo 'Las contraseñas no coinciden';
}else{
    $pass_en_md5 = md5($password);
    $sql ="UPDATE alumnos SET password = '$password' WHERE matricula = '$matricula'";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        echo 'Cambio exitoso';
    }
}
?>
