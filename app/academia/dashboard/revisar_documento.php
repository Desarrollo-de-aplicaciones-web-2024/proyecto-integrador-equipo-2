<?php
require_once '../../consultas/documentos.php';

Documento::editById($_POST['id'], ['estatus' => $_POST['estatus'] === 'approve' ? 'aprobado' : 'rechazado', 'motivo' => $_POST['motivo']]);
header('Location: documentosPendientes.php');
