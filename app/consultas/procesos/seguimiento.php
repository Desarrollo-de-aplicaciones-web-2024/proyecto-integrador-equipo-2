<?php
require_once '../../../config/global.php';

define('RUTA_INCLUDE', '../../../'); //ajustar a necesidad
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CSS Template</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../vendor/bootstrap/scss/bootstrap.scss">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }








        /* Style the content */
        .content {
            margin-left: 200px;
            padding-left: 20px;
        }

        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Style the top navigation bar */
        .topnav {
            overflow: hidden;
            background-color: lightskyblue;
        }

        /* Style the topnav links */
        .topnav a {
            float: left;
            display: block;
            color: gray;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }



        /* Style the content */
        .content {
            background-color: white;
            padding: 10px;
            height: 200px;
        }

       /* table {

            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }*/



    </style>

    <?php getTopIncludes(RUTA_INCLUDE ) ?>
</head>

<body>

<div class="topnav">
    <a href="#">Convocatorias</a>
    <a href="#">Practicas</a>
    <a href="#">Salir</a>
</div>







<div class="content">
    <h2>Seguimiento de Prácticas</h2>
    <p>Prácticas en curso</p>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Alumno</th>
        <th>Carrera</th>
        <th>Semestre</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Horas</th>
        <th>Empresa</th>
        <th>Departamento</th>
        <th>Supervisor</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Procoro Juarez Luna</td>
        <td>Ing. en Sistemas Computacionales</td>
        <td>6to</td>
        <td>20/04/2024</td>
        <td>20/08/2024</td>
        <td>240</td>
        <td>Microna</td>
        <td>TI</td>
        <td>Dr. Jaime Martínez Castillo</td>
    </tr>
    <tr>
        <td>Axel Yahir Escobar Alatorre</td>
        <td>Ing. en Sistemas Computacionales</td>
        <td>6to</td>
        <td>16/05/2024</td>
        <td>16/09/2024</td>
        <td>240</td>
        <td>CISCO</td>
        <td>TI</td>
        <td>Eric Onofre Martinez</td>
    </tr>
    <tr>
        <td>Javier Jara Rentería</td>
        <td>Ing. en Sistemas Computacionales</td>
        <td>6to</td>
        <td>23/04/2024</td>
        <td>23/08/2024</td>
        <td>240</td>
        <td>Microsoft</td>
        <td>Desarrollo</td>
        <td>Pedro Diaz Abascal</td>
    </tr>
    </tbody>
</table>




</body>
</html>