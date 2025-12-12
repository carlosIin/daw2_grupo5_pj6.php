<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$fitxer = RUTA_PRODUCTES . '/productes.json';
$dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistar productes</title>
</head>
<body>
    <h1>Llista de productes</h1>
    <ul>
    <?php
    foreach($dades as $id => $info) {
        echo "<li>$id - {$info['nom']} ({$info['preu']} €) (<a href='visualitzar.php?id=$id'>Veure</a>)</li>";
    }
    ?>
    </ul>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
