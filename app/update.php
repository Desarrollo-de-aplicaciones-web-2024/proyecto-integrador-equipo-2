<?php
require '../config/db.php';

global $conexion;

$matricula = $_POST['matricula'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// get latest record with a given matricula
$sql = "SELECT * from password_resets WHERE matricula = ? ORDER BY id DESC LIMIT 1";
$stmt = $conexion->prepare($sql);

if ($stmt = mysqli_prepare($conexion, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $matricula);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if($password != $password2){
    echo 'Las contraseñas no coinciden';
} else {
    $pass_en_md5 = md5($password);

    if ($data['type'] == 'academia') {
        $sql = "UPDATE academia SET password = ? WHERE numero_empleado = ?";
    } else {
        $sql = "UPDATE alumnos SET password = ? WHERE matricula = ?";
    }

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $pass_en_md5, $matricula);
    mysqli_stmt_execute($stmt);
    $affected_rows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($affected_rows > 0) {
        echo 'Cambio exitoso';
        header("Location: index.php");
    } else if ($affected_rows === 0) {
        echo 'La contraseña ya está actualizada';
    } else {
        echo 'Error al cambiar la contraseña';
    }
}
