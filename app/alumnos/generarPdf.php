<?php
require_once  '../../vendor/dompdf-3.0.0/dompdf/autoload.inc.php';
require '../../config/db.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);

$matricula = $_POST['matricula'];
$id_empresa = $_POST['id-empresa'];
$puesto = $_POST['puesto'];
$duracion = $_POST['duracion'];
$departamento = $_POST['departamento'];
$horas = $_POST['horas'];
$fecha_inicio = $_POST['fecha-inicio'];
$fecha_inicio = $_POST['fecha-fin'];
$nombre_supervisor = $_POST['supervisor'];
$puesto_supervisor = $_POST['puesto-supervisor'];
$id_carrera = $_POST['id-carrera'];


//estos 2 queries se podrian fusionar en 1 solo
//falta validacion qeu rediriga con mensajes de error a carga-documentos-iniciales

$sql_select_data = "SELECT c.nombre AS nombre_carrera, e.nombre AS nombre_empresa, e.email as email_empresa, e.telefono as telefono_empresa, e.ciudad as ciudad_empresa, e.direccion as direccion_empresa, a.nombre AS nombre_alumno, a.sexo as sexo_alumno, a.semestre as semestre_alumno FROM carreras c JOIN empresas e ON e.id = '$id_empresa'JOIN alumnos a ON a.matricula = '$matricula'WHERE c.id = '$id_carrera';";
$res = mysqli_query($conexion, $sql_select_data);
$res_data = mysqli_fetch_assoc($res);

$nombre_carrera = $res_data['nombre_carrera'];
$nombre_empresa = $res_data['nombre_empresa'];
$direccion = $res_data['direccion_empresa'];
$telefono = $res_data['telefono_empresa'];
$correo = $res_data['email_empresa'];
$nombre_alumno = $res_data['nombre_alumno'];
$sexo_alumno = $res_data['sexo_alumno'] == 'M'? 'Hombre' : 'Mujer';
$semestre_alumno = $res_data['semestre_alumno'];

$fecha = new DateTime();
$fechaFormateada = $fecha->format('d/m/y');
$dia_del_anio = sprintf('%03d', $fecha->format('z') + 1);
$dia_semana = $fecha->format('l');
$semana_del_anio = $fecha->format('W');

// Arrays para los meses y días de la semana en español
$meses = array(
    1 => "enero",
    2 => "febrero",
    3 => "marzo",
    4 => "abril",
    5 => "mayo",
    6 => "junio",
    7 => "julio",
    8 => "agosto",
    9 => "septiembre",
    10 => "octubre",
    11 => "noviembre",
    12 => "diciembre"
);

$dias_semana = array(
    "Monday" => "lunes",
    "Tuesday" => "martes",
    "Wednesday" => "miércoles",
    "Thursday" => "jueves",
    "Friday" => "viernes",
    "Saturday" => "sábado",
    "Sunday" => "domingo"
);

// Obtén las partes de la fecha
$partes_fecha = explode("-", $fecha->format('Y-m-d'));
$dia = intval($partes_fecha[2]);
$mes = intval($partes_fecha[1]);
$anio = $partes_fecha[0];

//echo "<ul>
//            <li>La fecha <b>$dia de {$meses[$mes]} de $anio</b></li>
//            <li>siendo el día <b>$dia_del_anio</b></li>
//            <li>cayó en <b>{$dias_semana[$dia_semana]}</b></li>
//            <li>de la semana <b>$semana_del_anio</b> del año</li>
//        </ul>";

$data = "
<!DOCTYPE html>
<html>
<head>
    <title>Solicitud de inicio de prácticas profesionales</title>
    <style>
        .titulo {
            width: 100%;
        }
        .titulo img {
            vertical-align: middle;
        }
        .titulo h1 {
            display: inline-block;
            vertical-align: middle;
            font-size: 18px;
            text-align: center;
        }
        .titulo span{
            text-decoration: #0b2e13;
            text-decoration-style: solid;
        }
        .titulo td {
            vertical-align: middle;
        }

        .alumno{
            width: 100%;
            border-collapse: collapse;

        }

        .alumno th {
            background-color: #dadada;
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }

        .alumno td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }


        .empresa{
            width: 100%;
            border-collapse: collapse;

        }

        .empresa th {
            background-color: #dadada;
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }

        .empresa td {
            border: 1px solid black;
            padding: 2px;
            text-align: left;
        }

        .section-title h1{
            margin-top: 0px;
            margin-bottom: 0;
            font-size: 20px;
            text-align: center;
            background: #808181;
            border: 1px solid black;
            border-bottom: 0px;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        p {
            text-align: justify;
        }

        .signatures-table {
            width: 100%;
            margin-top: 20px;
            text-align: center;

        }

        #alumno {
            padding: 2px;
            border-top: 1px solid black;
            width: 250px;
            text-align: center;
        }

        #supervisor {
            padding: 2px;
            border-top: 1px dotted black;
            width: 250px;

        }
        .divider {
            width: 40px;
        }

    </style>
</head>
<body>
    <table class='titulo'>
        <tr>
            <td>
                <img src='https://upload.wikimedia.org/wikipedia/commons/6/62/Logo_de_la_Universidad_Crist%C3%B3bal_Col%C3%B3n.svg' height='100px'>
            </td>
            <td>
                <h1>$nombre_carrera<br><span>Solicitud para realización de Prácticas Profesionales</span></h1>
            </td>
        </tr>
    </table>


    <table class='subtitle'>
            <p><b>Mtro. Ramón Palet Naranjo</b></p>
            <p>
            <b>
                Jefe Académico de las Licenciaturas en Ingeniería en Sistemas Computacionales, Ingeniería en Telecomunicaciones y Sistemas Electrónicos, Ingeniería Biónica e Ingeniería Mecatrónica.
                Universidad Cristóbal Colón
            </b>
            </p>

            <p>Por medio de la presente hago de su conocimiento mi deseo de realizar prácticas profesionales en la empresa que a continuación se detalla. Esto con el fin de fortalecer mi formación académica y vincularme con el medio laboral.</p>
    </table>

    <div class='section-title'>
        <h1>Datos del alumno</h1>
    </div>

    <table class='alumno'>
        <tr>
            <th>1. Nombre:</th>
            <td>$nombre_alumno</td>

            <th>2. Matrícula:</th>
            <td>$matricula</td>
        </tr>
        <tr>
            <th>3. Licenciatura:</th>
            <td>$nombre_carrera</td>

             <th>4. Semestre</th>
            <td>$semestre_alumno</td>
        </tr>
        <tr>
            <th>5. E mail:</th>
            <td>$correo</td>

            <th>6. Sexo:</th>
            <td>$sexo_alumno</td>
        </tr>
        
    </table>
    <br>
    <div class='section-title'>
        <h1>Datos de la empresa</h1>
    </div>
    <table class='empresa'>
        <tr>
            <th>1. Nombre o razón social</th>
            <td>$nombre_empresa</td>
        </tr>
        <tr>
            <th>2. Domicilio</th>
            <td>$direccion</td>
        </tr>
        <tr>
            <th>3. Teléfono</th>
            <td>$telefono</td>
        </tr>
        <tr>
            <th>4. E mail</th>
            <td>$correo</td>
        </tr>
        <tr>
            <th>5. Duración de las prácticas</th>
            <td>$duracion horas</td>
        </tr>
        <tr>
            <th>6. Puesto tentativo a desempeñar</th>
            <td>$puesto</td>
        </tr>
        <tr>
            <th>7. Departamento</th>
            <td>$departamento</td>
        </tr>
        <tr>
            <th>8. Nombre del supervisor directo</th>
            <td>$nombre_supervisor</td>
        </tr>
        <tr>
            <th>9. Puesto del supervisor directo</th>
            <td>$puesto_supervisor</td>
        </tr>
    </table>

    <p>Doy fe que los datos anteriores son fidedignos y me comprometo a cumplir con los lineamientos establecidos por la empresa, así como por el reglamento general de alumnos de la Universidad Cristóbal Colón.</p>
    <p>H. Veracruz, Ver., a	    $dia	de	{$meses[$mes]}	de	$anio </p>
   <br>
    <table class='signatures-table'>
        <tr>
            <td id='alumno'><span >$nombre_alumno</span><br><span>Alumno</span></td>

            <td class='divider'>
                <td id='alumno'><span >$nombre_supervisor</span><br><span>Supervisor</span></td>
            </td>
        </tr>
   <br>
   <br>

        <tr>
            <td id='alumno'><span >Mtro. Ramón Palet Naranjo</span><br><span>Vo. Bo. Jefe de Área Académica</span></td>

            <td class='divider'>
                <td id='alumno'><span >Mtra. María del Carmen Aguirre Torres</span><br><span>Vo. Bo. Aseguramiento de la Calidad</span></td>
            </td>
        </tr>
    </table>
</body>
</html>
";;
//
$dompdf->loadHtml($data);
$dompdf->setPaper('A4','vertical');
$dompdf->render();
$dompdf->stream('Solicitud de practicas', array("Attachment"=>1));