<?php
require_once '../../../config/db.php';

global $conexion;

class Alumno
{
    static public function getById($id)
    {
        global $conexion;
        $query = "SELECT * FROM alumnos WHERE id = ?";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $data;
        } else {
            return null;
        }
    }

    static public function getAll()
    {
        global $conexion;
        $query = "SELECT * FROM alumnos";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_all($result);
            mysqli_stmt_close($stmt);
            return $data;
        } else {
            return null;
        }
    }

    static public function create($matricula, $nombre, $sexo, $semestre, $password)
    {
        global $conexion;
        $query = "INSERT INTO alumnos (matricula, nombre, sexo, semestre, password) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "sssss", $matricula, $nombre, $sexo, $semestre, $password);
            mysqli_stmt_execute($stmt);
            $id = mysqli_insert_id($conexion);
            mysqli_stmt_close($stmt);
            return $id;
        } else {
            return null;
        }
    }

    static public function update($id, $matricula, $nombre, $sexo, $semestre, $password)
    {
        global $conexion;
        $query = "UPDATE alumnos SET matricula = ?, nombre = ?, sexo = ?, semestre = ?, password = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "sssssi", $matricula, $nombre, $sexo, $semestre, $password, $id);
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
        $query = "DELETE FROM alumnos WHERE id = ?";

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
