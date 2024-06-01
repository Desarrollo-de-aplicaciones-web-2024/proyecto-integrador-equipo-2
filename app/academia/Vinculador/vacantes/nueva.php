<?php
require_once '../../../../config/db.php';
global $conexion;

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empresa = $_POST['empresa'];
    $descripcion = $_POST['descripcion'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $vacantes = $_POST['vacantes'];
    $perfiles = isset($_POST['perfiles']) ? implode(", ", $_POST['perfiles']) : "";

    // Manejar la subida de archivos
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $imagen_destino = "uploads/" . basename($imagen_nombre);

        // Mover el archivo subido al destino final
        if (move_uploaded_file($imagen_temp, $imagen_destino)) {
            $sql = "INSERT INTO convocatoria (empresa, descripcion, imagen, correo, telefono, perfiles, vacantes)
                    VALUES ('$empresa', '$descripcion', '$imagen_destino', '$correo', '$telefono', '$perfiles', '$vacantes')";

            if ($conexion->query($sql) === TRUE) {
                echo "Nuevo registro creado exitosamente";
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "No se ha subido ningún archivo o hubo un error en la subida.";
    }
}

$conexion->close();
?>
