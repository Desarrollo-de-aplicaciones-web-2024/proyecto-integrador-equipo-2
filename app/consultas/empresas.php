<?php
require_once '../../../config/db.php';

global $conexion;

class Empresa
{
    static public function getById($id)
    {
        global $conexion;
        $query = "SELECT * FROM empresas WHERE id = ?";

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
        $query = "SELECT * FROM empresas";

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

    static public function create($nombre, $direccion, $telefono, $correo)
    {
        global $conexion;
        $query = "INSERT INTO empresas (nombre, direccion, telefono, correo) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "ssss", $nombre, $direccion, $telefono, $correo);
            mysqli_stmt_execute($stmt);
            $id = mysqli_insert_id($conexion);
            mysqli_stmt_close($stmt);
            return $id;
        } else {
            return null;
        }
    }

    static public function update($id, $nombre, $direccion, $telefono, $correo)
    {
        global $conexion;
        $query = "UPDATE empresas SET nombre = ?, direccion = ?, telefono = ?, correo = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $direccion, $telefono, $correo, $id);
            mysqli_stmt_execute($stmt);
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $affected_rows;
        } else {
            return null;
        }
    }

    static public function delete($id)
    {
        global $conexion;
        $query = "DELETE FROM empresas WHERE id = ?";

        if ($stmt = mysqli_prepare($conexion, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $affected_rows;
        } else {
            return null;
        }
    }
}
