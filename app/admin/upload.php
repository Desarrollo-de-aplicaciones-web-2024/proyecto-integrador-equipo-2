<?php
    // Comprobar si el archivo fue subido sin errores
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file_tmp_path = $_FILES['csv_file']['tmp_name'];
        $file_name = $_FILES['csv_file']['name'];
        $file_size = $_FILES['csv_file']['size'];
        $file_type = $_FILES['csv_file']['type'];

        $allowed_ext = array("csv" => "text/csv");

        // Verificar la extensión del archivo
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!array_key_exists($file_ext, $allowed_ext)) {
            die("Error: Por favor, sube un archivo CSV.");
        }

        if (($handle = fopen($file_tmp_path, "r")) !== FALSE) {
            require '../../config/db.php';


            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }


            $header = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($header) {
                    $header = false;
                    continue;
                }

                $matricula = $conexion->real_escape_string($data[0]);
                $nombre = $conexion->real_escape_string($data[1]);
                $sexo = $conexion->real_escape_string($data[2]);
                $carrera =$conexion->real_escape_string($data[3]);
                $semestre = $conexion->real_escape_string($data[4]);
                $password = $conexion->real_escape_string($data[5]);
                $pass_en_md5 = md5($password);

               //Revisar Id de carrera
                $carrsql = "SELECT id from carreras WHERE nombre = '$carrera'";
                $stmt = $conexion->prepare($carrsql);
                if ($stmt) {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $carrera_id = $row['id'];
                    } else {
                        $result = '';
                    }
                    // Cerrar la declaración
                    $stmt->close();
                }

                $sql = "INSERT INTO alumnos (matricula,nombre, sexo, semestre, password) VALUES ('$matricula', '$nombre', '$sexo', '$semestre', '$pass_en_md5')";
                $sql2 = "insert into carrera_alumno (matricula_alumno, id_carrera) values ('$matricula','$carrera_id')";

                if ($conexion->query($sql)) {
                    $stmt = $conexion->prepare($sql2);
                    if ($stmt) {
                        $stmt->execute();
                    }

                }else{
                    echo "Error: " . $sql . "<br>" . $conexion->error;
                }
            }
            fclose($handle);
            $conexion->close();

            echo "Registros subidos exitosamente.";
        } else {
            echo "Error al abrir el archivo.";
        }
    } else {
        echo "Error: " . $_FILES['csv_file']['error'];
    }
?>
