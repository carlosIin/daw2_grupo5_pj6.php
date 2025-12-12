<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    exit("Accés denegat");
}

$fitxer_dir = RUTA_COMANDES . '/../comandes_no_gestionades';
$fitxers = glob($fitxer_dir . '/*.json');
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llista comandes no gestionades</title>
</head>
<body>
    <h1>Llista de comandes no gestionades</h1>
    <?php if(empty($fitxers)): ?>
        <p>No hi ha comandes pendents.</p>
    <?php else: ?>
        <ul>
            <?php foreach($fitxers as $fitxer): 
                $nom_fitxer = basename($fitxer);
                ?>
                <li>
                    <a href="visualitzar.php?fitxer=<?php echo urlencode($nom_fitxer); ?>">
                        <?php echo $nom_fitxer; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
