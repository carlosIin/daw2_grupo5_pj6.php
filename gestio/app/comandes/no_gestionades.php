<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$directori = RUTA_COMANDES;
$comandes = glob($directori . '/*.json');
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Comandes no gestionades</title>
</head>
<body>
    <h1>Comandes no gestionades</h1>
    <?php if(empty($comandes)): ?>
        <p>No hi ha comandes pendents.</p>
    <?php else: ?>
        <ul>
            <?php foreach($comandes as $fitxer): 
                $nom_fitxer = basename($fitxer);
            ?>
                <li>
                    <?= $nom_fitxer ?> 
                    (<a href="visualitzar.php?fitxer=<?= $nom_fitxer ?>">Veure</a> | 
                    <a href="procesar.php?fitxer=<?= $nom_fitxer ?>">Procesar</a> | 
                    <a href="enviar_correu.php?fitxer=<?= $nom_fitxer ?>">Enviar correu</a>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
