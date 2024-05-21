<?php
require_once  '../../vendor/dompdf-3.0.0/dompdf/autoload.inc.php';
require '../../config/db.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();

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

//estos 2 queries se podrian fusionar en 1 solo
//falta validacion qeu rediriga con mensajes de error a carga-documentos-iniciales

$sql_select_empresa = "SELECT empresas.id,empresas.nombre, empresas.email, empresas.telefono, empresas.giro, empresas.ciudad, empresas.direccion, giros.nombre AS nombre_giro from empresas LEFT JOIN giros ON empresas.giro = giros.id where empresas.id = '$id_empresa' ";
$res = mysqli_query($conexion, $sql_select_empresa);
$empresa = mysqli_fetch_assoc($res);

$nombre_empresa = $empresa['nombre'];
$giro_empresa = $empresa['nombre_giro'];
$direccion = $empresa['direccion'];
$telefono = $empresa['telefono'];
$correo = $empresa['email'];

$sql_select_alumno = "select * from alumnos where matricula = '$matricula'";
$res2 = mysqli_query($conexion, $sql_select_alumno);
$alumno = mysqli_fetch_assoc($res2);
$nombre_alumno = $alumno['nombre'];

//ejemplo de generar un documento

$data = '';
$data .= "<h1>Hola, $nombre_alumno </h1>";

$data .= "<p>Tu vas para la empresa $nombre_empresa con el giro $giro_empresa</p>";
$data .= "<p>Direccion: $direccion</p>";
$data .= "<p>Telefono: $telefono</p>";
$data .= "<p>Te vas a desempeñar en el puesto <strong>$puesto</strong> en <strong>$departamento</strong> durante <strong>$duracion</strong> meses por <strong>$horas</strong> horas</p>";
$data .= "<p>Buena suerte, incias este $fecha_inicio</p>";


$dompdf->loadHtml($data);
$dompdf->setPaper('A4','vertical');
$dompdf->render();
$dompdf->stream();
