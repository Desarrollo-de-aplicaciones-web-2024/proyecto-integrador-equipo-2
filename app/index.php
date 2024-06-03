<?php define('RUTA_INCLUDE', '');?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Universidad Cristóbal Colón</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link href="../img/favicon.ico" rel="shortcut icon" type="image/png"/>

</head>

<body>

<div>
    <div class="card card-login mx-auto border-light mb-3">
        <img src="../img/Logo.png" class="card-img">
            <form action="login.php" method="post">
                <div class="row g-0"">
                    <div  class="card-body">
                        <div class="form-group">
                            <div class="form-label-group">
                                <p>Matrícula</p>
                                <input type="text" id="matricula" name="matricula" class="form-control-sm"
                                style="border-radius: 15px; height: 35px;">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <p>Contraseña</p>
                                <input type="password" id="pass" name="pass" class="form-control-sm"
                                style="border-radius: 15px; height: 35px;">
                            </div>
                        </div>
                    </div>
                <div class="row g-0">
                        <div class="card-body">
                            <br><br><br>
                            <button type="submit" class="btn btn-primary"
                               style=" background-color:#0D0835; border-radius: 12px; width: 160px;" href="login.php" role="button">
                                Iniciar sesión
                            </button>
                            </form>
                            <div class="text-center">
                                <a class="d-block small mt-3" href="recuperar.php">Recuperar contraseña</a>
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
