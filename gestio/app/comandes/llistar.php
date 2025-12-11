<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

// Llistar totes les comandes (gestionades i no gestionades)
$comandes_no_gestionades = glob(RUTA_COMANDES . '/*.json');
$comandes_gestionades = glob(RUTA_COMANDES_GESTIONADES . '/*.json');
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistar comandes</title>
</head>
<body>
    <h1>Llista de comandes</h1>
    <h2>No gestionades</h2>
    <ul>
        <?php foreach($comandes_no_gestionades as $fitxer): ?>
            <li><?= basename($fitxer) ?> (<a href="visualitzar.php?fitxer=<?= basename($fitxer) ?>">Veure</a>)</li>
        <?php endforeach; ?>
    </ul>

    <h2>Gestionades</h2>
    <ul>
        <?php foreach($comandes_gestionades as $fitxer): ?>
            <li><?= basename($fitxer) ?> (<a href="visualitzar.php?fitxer=<?= basename($fitxer) ?>">Veure</a>)</li>
        <?php endforeach; ?>
    </ul>

    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
