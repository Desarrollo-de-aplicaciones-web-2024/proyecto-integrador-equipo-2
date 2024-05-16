<?php

//require '../../config/db.php';
//
//$sql = "select * from empresas";
//$res = mysqli_query($conexion, $sql);


echo '
<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Empresas</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

        <table class="table">
            <tr>
                <th>Nombre de la Empresa</th>
                <th>Giro</th>
                <th>Vencimiento convenio</th>
            </tr>
            <tr>
                <td>Empresa 1</td>
                <td>Tecnología</td>
                <td>01/01/2025</td>
            </tr>
            <tr>
                <td>Empresa 2</td>
                <td>Finanzas</td>
                <td>15/06/2024</td>
            </tr>
            <tr>
                <td>Empresa 3</td>
                <td>Salud</td>
                <td>30/09/2023</td>
            </tr>
            <tr>
                <td>Empresa 4</td>
                <td>Educación</td>
                <td>22/11/2024</td>
            </tr>
            <tr>
                <td>Empresa 5</td>
                <td>Manufactura</td>
                <td>05/04/2023</td>
            </tr>
        </table>

</body>
</html>
';
?>
