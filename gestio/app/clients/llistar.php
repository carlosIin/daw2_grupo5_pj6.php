<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$fitxer_clients = RUTA_CLIENTS . '/clients.json';
$dades = file_exists($fitxer_clients) ? json_decode(file_get_contents($fitxer_clients), true) : [];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistar clients</title>
</head>
<body>
    <h1>Llista de clients</h1>
    <ul>
    <?php
    foreach($dades as $usuari => $info) {
        echo "<li>$usuari - {$info['nom']} {$info['cognoms']} (<a href='visualitzar.php?usuari=$usuari'>Veure</a>)</li>";
    }
    ?>
    </ul>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
