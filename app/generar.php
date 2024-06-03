<?php

require '../config/db.php';

global $conexion;

if (empty($_GET['token'])) {
    die('Token no válido.');
}

$query = "SELECT * FROM password_resets WHERE token = ? AND expiry > NOW()";

if ($stmt = mysqli_prepare($conexion, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $_GET['token']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (empty($data)) {
    die('Token no válido.');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recuperar contraseña</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link href="../img/favicon.ico" rel="shortcut icon" type="image/png"/>

</head>

<body class="bg-dark">

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Recuperar contraseña</div>
        <div class="card-body">
            <form action="verificacion.php" method="post">
                <div class="form-group">
                    <div class="form-label-group">
                        <p>Codigo</p>
                        <input type="number" id="codigo" name="codigo" class="form-control-sm"
                               style="border-radius: 15px; height: 35px;">
                        <input type="hidden" id="matricula" name="matricula" value="<?= $data['matricula'] ?>"
                               class="form-control-sm">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Verificar</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
