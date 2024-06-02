<?php
require '../../config/db.php';
$codigo = $_POST['codigo'];
$email  = $_POST['email'];
$token = $_POST['token'];
$matricula = $_POST['matricula'];
$sql = "SELECT * from passwords WHERE email = '$email' and token = '$token' and codigo = '$codigo' ";
$stmt = $conexion->prepare($sql);
if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fecha = $row['fecha'];
        $fecha_actual = date("Y-m-d h:m:s");
        $seconds = strtotime($fecha_actual) - strtotime($fecha);
        $minutos=$seconds/60;
        if($minutos> 15){
        echo 'Codigo vencido';
        }else{
            header("Location: cambio.php?matricula='$matricula'");
        }
    } else {
        echo 'Codigo incorrecto';
    }
    // Cerrar la declaración
    $stmt->close();
}
?>
