<?php
require_once '../../consultas/documentos.php';

Documento::editById($_POST['id'], ['estatus' => isset($_POST['approve']) ? 'aprobado' : 'rechazado', 'motivo' => $_POST['motivo'] ?? null]);

if (isset($_POST['approve'])) {
    // si hay solicitud, plan de trabajo y carta de aceptacion aprobados, cambiar el estatus de la practica a aprobado
    $documentoActual = Documento::getById($_POST['id']);
    $documentos = Documento::getAllByPractica($documentoActual['id_practica']);

    // get array like [solicitud => 'aprobado', plan_trabajo => 'aprobado', carta_aceptacion => 'aprobado']
    $documentosStatus = array_reduce($documentos, function ($carry, $item) {
        $carry[$item['tipo']] = $item['estatus'];
        return $carry;
    }, []);

    // if everything is approved, approve the practica
    if ($documentosStatus['solicitud'] === 'aprobado' && $documentosStatus['plan-trabajo'] === 'aprobado' && $documentosStatus['carta-aceptacion'] === 'aprobado') {
        $practica = Practica::getById($documentoActual['id_practica']);
        Practica::editById($practica['id'], ['estatus' => 'activo']);
    }
}

if (isset($_POST['reject'])) {
    $documentoActual = Documento::getById($_POST['id']);
    $documentos = Documento::getAllByPractica($documentoActual['id_practica']);

    // get array like [solicitud => 'aprobado', plan_trabajo => 'aprobado', carta_aceptacion => 'aprobado']
    $documentosStatus = array_reduce($documentos, function ($carry, $item) {
        $carry[$item['tipo']] = $item['estatus'];
        return $carry;
    }, []);

    // if at least one is rejected, set practica as pendiente
    if ($documentosStatus['solicitud'] === 'rechazado' || $documentosStatus['plan-trabajo'] === 'rechazado' || $documentosStatus['carta-aceptacion'] === 'rechazado') {
        $practica = Practica::getById($documentoActual['id_practica']);
        Practica::editById($practica['id'], ['estatus' => 'pendiente']);
    }
}

header('Location: documentosPendientes.php');
