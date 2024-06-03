<?php
session_start();
require "../../config/db.php";
$practica_id = $_POST['practica-id'];

function checkSize($fileIndex)
{
    $max_size = 5 * 1024 * 1024;

    if ($_FILES[$fileIndex]["size"] > $max_size) {
        $_SESSION["status"] = "error";
        $_SESSION["mensaje"] = "El archivo " . $_FILES[$fileIndex]["name"] . " no puede ser mayor a 5MB";
        header("Location: carga-documentos-iniciales.php");
        exit();
    }
}

function checkPDF($fileIndex)
{
    $type = mime_content_type($_FILES[$fileIndex]["tmp_name"]);
    if ($type != "application/pdf") {
        $_SESSION["status"] = "error";
        $_SESSION["mensaje"] = "El archivo " . $_FILES[$fileIndex]["name"] . " no tiene la extensión .pdf";
        header("Location: carga-documentos-iniciales.php");
        exit();
    }
}

function actualizarArchivo($fileIndex)
{
    require "../../config/db.php";
    $targetDir = "../servicio/inicial/"; // Cambiar a la ruta correcta

    // Comprobar si el directorio de destino existe, si no, crearlo
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $practica_id = $_POST['practica-id'];

    // Generar un UUID único para el nuevo archivo
    $uuid = uniqid(time(), true);

    // Ruta completa del archivo existente
    $existingFile = $targetDir . $fileIndex . "-" . $practica_id . ".pdf";

    // Si el archivo existente existe, eliminarlo
    if (file_exists($existingFile)) {
        unlink($existingFile);
    }

    // Ruta completa de destino incluyendo el nombre del nuevo archivo con UUID
    $targetFile = $targetDir . $uuid . ".pdf";

    if (!move_uploaded_file($_FILES[$fileIndex]["tmp_name"], $targetFile)) {
        $_SESSION["status"] = "error";
        $_SESSION["mensaje"] = "Error al subir " . $_FILES[$fileIndex]["name"];
        header("Location: carga-documentos-iniciales.php");
        exit();
    }

    // Ruta para la base de datos sin los puntos (..)
    $rutaParaDB = "/servicio/inicial/" . $uuid . ".pdf";

    $sql_update = "UPDATE documentos SET ruta = '$rutaParaDB', estatus = 'pendiente' WHERE id_practica = $practica_id AND tipo = '$fileIndex'";
    if (!mysqli_query($conexion, $sql_update)) {
        $_SESSION["status"] = "error";
        $_SESSION["mensaje"] = "Error al actualizar " . $_FILES[$fileIndex]["name"];
        header("Location: carga-documentos-iniciales.php");
        exit();
    }
}



// Validar tamaño del archivo

if (isset($_FILES["solicitud"]) && $_FILES["solicitud"]["error"] == 0) {
    checkSize("solicitud");
    checkPDF("solicitud");
    actualizarArchivo("solicitud");

}

if (isset($_FILES["plan-trabajo"]) && $_FILES["plan-trabajo"]["error"] == 0) {
    checkSize("plan-trabajo");
    checkPDF("plan-trabajo");
    actualizarArchivo("plan-trabajo");

}

if (isset($_FILES["carta-aceptacion"]) && $_FILES["carta-aceptacion"]["error"] == 0) {
    checkSize("carta-aceptacion");
    checkPDF("carta-aceptacion");
    actualizarArchivo("carta-aceptacion");

}


//cambiar el estado de la practica a 'revision'
$practica_id = $_POST["practica-id"];
$sql_update_practica = "UPDATE practicas set estatus = 'revision' WHERE id = $practica_id";
if (!mysqli_query($conexion, $sql_update_practica)) {
    $_SESSION["status"] = "error";
    $_SESSION["mensaje"] = "Error al actualizar la practica";
    header("Location: carga-documentos-iniciales.php");
    exit();
}

// Redirigir a una página de éxito
header("Location: mis-practicas.php");
exit();