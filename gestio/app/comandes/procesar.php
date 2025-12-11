<?php
require_once '../config.php';
verificar_sessio();

$fitxer_nom = $_GET['fitxer'] ?? '';
$origen = RUTA_COMANDES . '/' . $fitxer_nom;
$destinacio = RUTA_COMANDES_GESTIONADES . '/' . $fitxer_nom;
$missatge = '';

if(file_exists($origen)) {
    if(rename($origen, $destinacio)) {
        $missatge = "Comanda procesada correctament.";
    } else {
        $missatge = "Error en processar la comanda.";
    }
} else {
    $missatge = "Comanda no trobada.";
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Procesar comanda</title>
</head>
<body>
    <h1>Procesar comanda</h1>
    <p><?= $missatge ?></p>
    <a href="no_gestionades.php">Tornar a les comandes no gestionades</a>
</body>
</html>
