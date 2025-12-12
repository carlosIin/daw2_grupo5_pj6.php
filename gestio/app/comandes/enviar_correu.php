<?php
require_once '../config.php';
require_once '../lib/correu.php'; // Fitxer amb funció enviar_correu()

$fitxer_nom = $_GET['fitxer'] ?? '';
$fitxer_ruta = RUTA_COMANDES_GESTIONADES . '/' . $fitxer_nom;

$missatge = '';

if(file_exists($fitxer_ruta)) {
    $comanda = json_decode(file_get_contents($fitxer_ruta), true);
    $email_client = $comanda['email'] ?? '';

    if($email_client) {
        if(enviar_correu($email_client, "Comanda processada", "La seva comanda $fitxer_nom ha estat processada.")) {
            $missatge = "Correu enviat correctament a $email_client";
        } else {
            $missatge = "Error enviant el correu";
        }
    } else {
        $missatge = "No hi ha email del client";
    }
} else {
    $missatge = "Comanda no trobada o no gestionada";
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Enviar correu comanda</title>
</head>
<body>
    <h1>Enviar correu comanda</h1>
    <p><?= $missatge ?></p>
    <a href="no_gestionades.php">Tornar a les comandes no gestionades</a>
</body>
</html>
