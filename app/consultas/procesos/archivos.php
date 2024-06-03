<?php
    //var_dump ($_FILES["socrates"]);
    $directorio = "uploads/";

    $archivo = $directorio . basename($_FILES["socrates"]["name"]);

    $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

    echo "Su reporte ha sido enviado";
?>
