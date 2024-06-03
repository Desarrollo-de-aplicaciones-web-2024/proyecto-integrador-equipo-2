<?php
session_start();
require '../../../../config/db.php';

$id_vacante = $_POST['id_vacante'];
$empresa_id = $_POST['empresa-id'];
$descripcion = $_POST['descripcion'];
$titulo = $_POST['titulo'];
$vacantes = $_POST['vacantes'] ?? 0;
$fecha_limite = $_POST['fecha-limite'] ?? null;

if ($fecha_limite == "0000-00-00") {
    $fecha_limite = null;
    echo "ceros";
    exit();
}

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


    if (move_uploaded_file($imagen_temp, $targetFile)) {
        $sql_update = "UPDATE convocatorias SET id_empresa = '$empresa_id', titulo = '$titulo', descripcion = '$descripcion', imagen = '$targetFile', vacantes = '$vacantes', fecha_limite = '$fecha_limite' WHERE id = '$id_vacante'";

        if ($conexion->query($sql_update) === TRUE) {
            echo "Nuevo registro creado exitosamente";
            $_SESSION['status'] = 'exito';
            $_SESSION['mensaje'] = 'Vacante actualizada correctamente';
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
    // Construimos la consulta de actualización sin la imagen
    $sql_update = "UPDATE convocatorias SET id_empresa = '$empresa_id', titulo = '$titulo', descripcion = '$descripcion', vacantes = '$vacantes', fecha_limite = '$fecha_limite' WHERE id = '$id_vacante'";
    // Ejecutamos la consulta
    if (mysqli_query($conexion, $sql_update)) {
        $_SESSION["status"] = "exito";
        $_SESSION["mensaje"] = "Vacante actualizada correctamente";
    } else {
        $_SESSION["status"] = "error";
        $_SESSION["mensaje"] = "Error al actualizar la vacante: " . mysqli_error($conexion);
    }

    header("Location: index.php");
}


