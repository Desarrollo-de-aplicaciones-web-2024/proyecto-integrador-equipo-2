<?php
require_once '../../../../config/db.php';
global $conexion;

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empresa = $_POST['empresa'];
    $descripcion = $_POST['descripcion'];

    $vacantes = $_POST['vacantes'];
    $perfiles = isset($_POST['perfiles']) ? implode(", ", $_POST['perfiles']) : "";


    //obtener datos de la empresa:
//    $sql_empresa = "SELECT telefeono, email from empresas where id = '$empresa'";
//    $res = mysqli_query($conexion, $sql_empresa);
//    $row = mysqli_fetch_assoc($res);

//    $correo = $row['email'];
//    $telefono = $row['telefono'];

    // Manejar la subida de archivos
    $targetDir = "./img/";
    // Comprobar si el directorio de destino existe, si no, crearlo
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];

        $targetFile = $targetDir . $imagen_nombre;

        // Mover el archivo subido al destino final
        if (move_uploaded_file($imagen_temp, $targetFile)) {

            $sql = "INSERT INTO convocatorias (id_empresa, descripcion, imagen, vacantes)
                    VALUES ('$empresa', '$descripcion', '$targetFile','$vacantes')";

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