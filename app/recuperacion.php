<?php
require '../config/db.php';

global $conexion;

$matricula = $_POST['matricula'];

// Determinar el tipo de usuario basado en la matrícula
if ($matricula >= 10000 && $matricula <= 99999) {
    $type = 'academia';
} elseif ($matricula >= 200000000) {
    $type = 'alumno';
} else {
    die("Matrícula no válida.");
}


// Verificar que la matrícula exista en la tabla correspondiente
if ($type == 'alumno') {
    $stmt = $conexion->prepare("SELECT matricula FROM alumnos WHERE matricula = ?");
} else {
    $stmt = $conexion->prepare("SELECT numero_empleado FROM academia WHERE numero_empleado = ?");
}
$stmt->bind_param('s', $matricula);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($email);
    $stmt->fetch();

    $token = bin2hex(random_bytes(50));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $code = rand(1000, 9999);

    // Almacenar token en la tabla de password_resets
    $stmt = $conexion->prepare("INSERT INTO password_resets (matricula, token, type, expiry, code) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssi', $email, $token, $type, $expiry, $code);
    $stmt->execute();

    // Enviar correo electrónico
    $reset_link = "http://$_SERVER[HTTP_HOST]/app/generar.php?token=$token&email=$matricula" . '@ucc.mx';


    $subject = "Recuperar Contraseña";
    $message = "Para restablecer tu contraseña, haz clic en el siguiente enlace: $reset_link" . PHP_EOL . PHP_EOL . "Código de verificación: $code";
    $headers = "From: soporte@ucc.mx";

    if (mail($matricula . '@ucc.mx', $subject, $message, $headers)) {
        echo "Enlace de recuperación enviado a tu correo electrónico.";
    } else {
        echo "Error al enviar el correo electrónico.";
    }
} else {
    echo "Matrícula no encontrada.";
}

exit;

