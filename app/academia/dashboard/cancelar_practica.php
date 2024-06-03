<?php
require_once '../../../config/db.php';
require_once '../../consultas/practicas.php';

global $conexion;

$practica_id = $_GET['id'];

Practica::editById($practica_id, ['estatus' => 'cancelado']);

header('Location: documentosPendientes.php');
