<?php
require_once '../config.php';
verificar_sessio();

$fitxer_nom = $_GET['fitxer'] ?? '';
$fitxer_ruta = '';

if (file_exists(RUTA_COMANDES.'/'.$fitxer_nom)) {
    $fitxer_ruta = RUTA_COMANDES.'/'.$fitxer_nom;
} elseif (file_exists(RUTA_COMANDES_GESTIONADES.'/'.$fitxer_nom)) {
    $fitxer_ruta = RUTA_COMANDES_GESTIONADES.'/'.$fitxer_nom;
} else {
    $error = "Comanda no trobada";
}

if(isset($fitxer_ruta)) {
    $comanda = json_decode(file_get_contents($fitxer_ruta), true);
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Visualitzar comanda</title>
</head>
<body>
    <h1>Visualitzar comanda</h1>
    <?php
    if(isset($error)) {
        echo "<p>$error</p>";
    } else {
        echo "<pre>" . json_encode($comanda, JSON_PRETTY_PRINT) . "</pre>";
    }
    ?>
    <a href="llistar.php">Tornar a la llista de comandes</a>
</body>
</html>
