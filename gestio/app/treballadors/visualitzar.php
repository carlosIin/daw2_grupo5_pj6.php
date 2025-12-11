<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador()) {
    echo "Accés denegat";
    exit();
}

$fitxer = RUTA_TREBALLADORS . '/treballadors.json';
$dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];

if (!$dades) {
    $error = "No hi ha treballadors";
} else {
    // Si no se pasa 'usuari', tomamos el primero
    $usuari_seleccionat = $_GET['usuari'] ?? array_values($dades)[0]['nom_usuari'];

    // Buscar por nom_usuari
    $treballador = null;
    $id_treballador = null;
    foreach ($dades as $id => $t) {
        if ($t['nom_usuari'] === $usuari_seleccionat) {
            $treballador = $t;
            $id_treballador = $id;
            break;
        }
    }

    if (!$treballador) {
        $error = "Treballador no trobat";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Visualitzar treballador</title>
</head>
<body>
    <h1>Visualitzar treballador</h1>

    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php else: ?>
        <p><strong>ID:</strong> <?php echo $id_treballador; ?></p>
        <p><strong>Usuari:</strong> <?php echo $treballador['nom_usuari']; ?></p>
        <p><strong>Tipus:</strong> <?php echo $treballador['tipus']; ?></p>
        <p><strong>Nom:</strong> <?php echo $treballador['nom'] . ' ' . $treballador['cognoms']; ?></p>
        <p><strong>Adreça:</strong> <?php echo $treballador['adreca']; ?></p>
        <p><strong>Email:</strong> <?php echo $treballador['email']; ?></p>
        <p><strong>Telèfon:</strong> <?php echo $treballador['telefon']; ?></p>
    <?php endif; ?>

    <h2>Altres treballadors</h2>
    <ul>
        <?php foreach ($dades as $t) : ?>
            <li>
                <a href="?usuari=<?php echo $t['nom_usuari']; ?>">
                    <?php echo $t['nom_usuari'] . ' (' . $t['nom'] . ' ' . $t['cognoms'] . ')'; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>

