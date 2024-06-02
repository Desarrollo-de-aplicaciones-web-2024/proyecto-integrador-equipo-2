<?php
require_once '../../../config/db.php';
require_once 'practicas.php';
require_once 'empresas.php';
require_once 'alumnos.php';
require_once 'giros.php';

global $conexion;

class Documento
{
    static public function getById($id)
    {
        global $conexion;
        $query = "SELECT * FROM documentos WHERE id = ?";
        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);

            // Fetch related practica
            $practica = Practica::getById($data['id_practica']);
            if ($practica) {
                $data['practica'] = $practica;
            }

            // Fetch related alumno
            $alumno = Alumno::getByMatricula($practica['matricula_alumno']);
            if ($alumno) {
                $data['practica']['alumno'] = $alumno;
            }

            // Fetch related empresa
            $empresa = Empresa::getById($practica['id_empresa']);
            if ($empresa) {
                $data['practica']['empresa'] = $empresa;
            }

            $giro = Giro::getById($empresa['giro']);
            if ($giro) {
                $data['practica']['empresa']['giro'] = $giro;
            }

            mysqli_stmt_close($stmt);
            return $data;
        } else {
            return null;
        }
    }

    static function getAll() {
        global $conexion;
        $query = "SELECT * FROM documentos";
        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $documentos = array();
            while ($row = mysqli_fetch_assoc($result)) {
                // Initialize array for the documento
                $documento = $row;

                // Fetch related practica
                $practica = Practica::getById($row['id_practica']);
                if ($practica) {
                    $documento['practica'] = $practica;
                }

                // Fetch related alumno
                $alumno = Alumno::getByMatricula($practica['matricula_alumno']);
                if ($alumno) {
                    $documento['practica']['alumno'] = $alumno;
                }

                // Fetch related empresa
                $empresa = Empresa::getById($practica['id_empresa']);
                if ($empresa) {
                    $documento['practica']['empresa'] = $empresa;
                }

                // Add documento to the array
                $documentos[] = $documento;
            }

            mysqli_stmt_close($stmt);
            return $documentos;
        } else {
            return null;
        }
    }







//    static public function create($matricula, $nombre, $sexo, $semestre, $password)
//    {
//        global $conexion;
//        $query = "INSERT INTO alumnos (matricula, nombre, sexo, semestre, password) VALUES (?, ?, ?, ?, ?)";
//
//        if ($stmt = mysqli_prepare($conexion, $query)) {
//            mysqli_stmt_bind_param($stmt, "sssss", $matricula, $nombre, $sexo, $semestre, $password);
//            mysqli_stmt_execute($stmt);
//            $id = mysqli_insert_id($conexion);
//            mysqli_stmt_close($stmt);
//            return $id;
//        } else {
//            return null;
//        }
//    }

//    static public function update($id, $matricula, $nombre, $sexo, $semestre, $password)
//    {
//        global $conexion;
//        $query = "UPDATE alumnos SET matricula = ?, nombre = ?, sexo = ?, semestre = ?, password = ? WHERE id = ?";
//
//        if ($stmt = mysqli_prepare($conexion, $query)) {
//            mysqli_stmt_bind_param($stmt, "sssssi", $matricula, $nombre, $sexo, $semestre, $password, $id);
//            mysqli_stmt_execute($stmt);
//            mysqli_stmt_close($stmt);
//            return true;
//        } else {
//            return false;
//        }
//    }

    static public function editById($id, $fields)
    {
        global $conexion;
        $query = "UPDATE documentos SET ";
        $types = "";
        $params = array();

        foreach ($fields as $field => $value) {
            $query .= "$field = ?, ";
            $types .= "s";
            $params[] = $value;
        }

        $query = substr($query, 0, -2);
        $query .= " WHERE id = ?";
        $types .= "i";
        $params[] = $id;

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return true;
        } else {
            return false;
        }
    }

    static public function delete($id)
    {
        global $conexion;
        $query = "DELETE FROM documentos WHERE id = ?";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return true;
        } else {
            return false;
        }
    }
}
