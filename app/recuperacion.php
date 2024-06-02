<?php
require '../config/db.php';
$matricula = $_POST['matricula'];
$correo = $matricula . "@ucc.mx";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'user@example.com';                     //SMTP username
    $mail->Password = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress($correo);              //Add a recipient


    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Recuperación de contraseña';
    $token = rand(1000,9999);
    $codigo = rand(1000,9999);

    $mail->Body = '<p>Su codigo de verificación es</p>
                    <h3>'.$codigo.'</h3>
                    <p>El código vencerá en 15 minutos</p>
                    <p><a href="generar.php?email= '.$correo.' &token= '.$token.' &matricula= '.$matricula.' ">Para restablecer da click aquí</a></p>';
    if($mail->send()){
        $sql = "insert into passwords (email, token, codigo) values ('$correo','$token','$codigo')";
        $stmt = $conexion->prepare($sql);
        if ($stmt) {
            $stmt->execute();
        }
    echo 'Correo enviado exitosamente, revise su bandeja de entrada';
    }
} catch (Exception $e) {
    echo "Correo no enviado. Error: {$mail->ErrorInfo}";
}
?>
