<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

// Directori de comandes no gestionades
$directori = __DIR__ . '/../comandes_no_gestionades';
$comandes = scandir($directori);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistar comandes no gestionades</title>
</head>
<body>
    <h1>Comandes no gestionades</h1>

    <?php
    $hi_ha_comandes = false;
    foreach($comandes as $fitxer) {
        if($fitxer != '.' && $fitxer != '..' && pathinfo($fitxer, PATHINFO_EXTENSION) === 'json') {
            $hi_ha_comandes = true;
            echo "<p><a href='visualitzar.php?fitxer=$fitxer'>$fitxer</a></p>";
        }
    }

    if(!$hi_ha_comandes) {
        echo "<p>No hi ha comandes pendents.</p>";
    }
    ?>

    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
