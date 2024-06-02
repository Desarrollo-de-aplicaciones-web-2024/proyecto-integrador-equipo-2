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
}