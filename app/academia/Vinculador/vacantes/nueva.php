<?php
session_start();
require_once '../../../../config/db.php';

$titulo = $_POST['titulo'];
$empresa_id = $_POST['empresa-id'];
$descripcion = $_POST['descripcion'];
$vacantes = $_POST['vacantes'];
$fecha_limite = $_POST['fecha-limite'] ?? "0000-00-00";
$nombre_imagen = $_FILES['imagen']['name'];

//// Manejar la subida de archivos
$targetDir = "./img/";
// Comprobar si el directorio de destino existe, si no, crearlo
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $extension_imagen = pathinfo($imagen_nombre, PATHINFO_EXTENSION);


    $targetFile = $targetDir . uniqid(time(), true) . '.' .$extension_imagen;

    // Mover el archivo subido al destino final
    if (move_uploaded_file($imagen_temp, $targetFile)) {

        $sql = "INSERT INTO convocatorias (id_empresa,titulo,descripcion,imagen,fecha_limite,vacantes,visible) VALUES ('$empresa_id', '$titulo','$descripcion', '$targetFile','$fecha_limite','$vacantes','1')";

        if ($conexion->query($sql) === TRUE) {
            echo "Nuevo registro creado exitosamente";
            $_SESSION['status'] = 'exito';
            $_SESSION['mensaje'] = 'Creada con exito';
            header('Location: index.php');
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['mensaje'] = 'Error al crear: ' .  $conexion->error;
            header('Location: index.php');
        }

    } else {
        echo "Error al subir el archivo.";
    }
} else {
    echo "No se ha subido ningún archivo o hubo un error en la subida.";
}