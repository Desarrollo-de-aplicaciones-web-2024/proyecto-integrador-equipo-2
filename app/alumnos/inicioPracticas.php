<?php

echo "
<!DOCTYPE html>
<html lang='es' data-theme='light'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Inicio prácticas</title>
    
    <link href='https://cdn.jsdelivr.net/npm/daisyui@4.11.1/dist/full.min.css' rel='stylesheet' type='text/css''/>
    <script src='https://cdn.tailwindcss.com'></script>
</head>

<h1>Inicio de prácticas profesionales</h1>

<nav>
<ul>
        <li><a href='convocatorias.php'>Convocatorias</a></li>
        <li><a href='salir.php'>Salir</a></li>
    </ul>
</nav>

<form action='' method='post'>

    <h2>Datos de la empresa</h2>
    
    <select name='empresa' id='empresa'>
    <option value='EnviosPerros'>EmviosPerros</option>
    <option value='Tamsa'>Tamsa</option>
    

    
    </select>
    
    <select name='giro-empresa' id='giro-empresa'>
    <option value='software'>Desarrollo</option>
    <option value='facturacion'>Facturación</option>
    
    </select>
    
       <label for='Domicilio'>Domicilio</label>
    <input id='Domicilio' type='text'>
    
            <label for='telefono'>Teléfono</label>
    <input id='telefono' type='tel'>
    
    
    <label class='input input-bordered flex items-center gap-2'>
  Name
  <input type='text' class='grow' placeholder='Daisy' />
</label>
    
    
    
    
     <select name='duracion-practica' id='duracion-practica'>
        <option value='3'>3 meses</option>
        <option value='6'>6 meses</option>
    </select>
    
    <label for='puesto'>Puesto tentativo a desempeñar</label>
    <input id='puesto' type='text'>
    
    <label for='puesto'>Departamento</label>
    <input id='departamento' type='text'>
    
    <label for='puesto'>Nombre supervisor directo</label>
    <input id='supervisor' type='text'>
    
        <label for='puesto'>Puesto supervisor directo</label>
    <input id='supervisor-puesto' type='text'>
    
    <h2>Documentos</h2>
    <label for='plan-trabajo'>Plan de trabajo</label>
    <input type='file' name='plan-trabajo' id='plan-trabajo'>
    
        <label for='carta aceptación'>Carta aceptación</label>
    <input type='file' name='carta aceptación' id='carta aceptación'>
    
        <label for='solicitud-practicas'>Solicitud</label>
    <input type='file' name='solicitud-practicas' id='solicitud-practicas'> //que solo sean pfs por ejemplo..
    
    <button type='submit'>Enviar</button>
</form>

";