<?php

class Practica {
    static function getById($id) {
        global $conexion;
        $query = "SELECT * FROM practicas WHERE id = ?";
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

    static function editById($id, $data) {
        global $conexion;
        $query = "UPDATE practicas SET ";
        $params = [];
        foreach ($data as $key => $value) {
            $query .= "$key = ?, ";
            $params[] = &$data[$key];
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE id = ?";
        $params[] = &$id;
        $types = str_repeat('s', count($params));
        $stmt = mysqli_prepare($conexion, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return true;
        } else {
            return false;
        }
    }
}