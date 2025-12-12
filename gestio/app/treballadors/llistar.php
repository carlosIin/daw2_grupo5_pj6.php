<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador()) {
    echo "Accés denegat";
    exit();
}

$fitxer = RUTA_TREBALLADORS . '/treballadors.json';
$dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistar treballadors</title>
</head>
<body>
    <h1>Llista de treballadors</h1>
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
