<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$fitxer_clients = RUTA_CLIENTS . '/clients.json';
$dades = file_exists($fitxer_clients) ? json_decode(file_get_contents($fitxer_clients), true) : [];

// Si no hay clientes en la BD
if (!$dades || count($dades) === 0) {
    die("<p>No hi ha clients registrats.</p><a href='../dashboard_admin.php'>Tornar</a>");
}

// Obtener primera clave del JSON
$primera_clau = array_key_first($dades);

// Ver si hay usuario seleccionado por GET, si no usar el primero
$usuari_seleccionat = $_GET['usuari'] ?? $primera_clau;

if (isset($dades[$usuari_seleccionat])) {
    $client = $dades[$usuari_seleccionat];
} else {
    $error = "Client no trobat";
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Visualitzar client</title>
</head>
<body>
    <h1>Visualitzar client</h1>

    <?php if (isset($error)): ?>

        <p><?= $error ?></p>

    <?php else: ?>

        <p><strong>Usuari:</strong> <?= $usuari_seleccionat ?></p>
        <p><strong>Nom:</strong> <?= $client['nom'] ?> <?= $client['cognoms'] ?></p>
        <p><strong>Adreça:</strong> <?= $client['adreca'] ?></p>
        <p><strong>Email:</strong> <?= $client['email'] ?></p>
        <p><strong>Telèfon:</strong> <?= $client['telefon'] ?></p>
        <p><strong>Número targeta:</strong> <?= $client['targeta'] ?></p>
        <p><strong>CCV:</strong> <?= $client['ccv'] ?></p>

    <?php endif; ?>

    <h2>Altres usuaris</h2>
    <ul>
        <?php foreach ($dades as $id => $cli): ?>
            <?php if ($id != $usuari_seleccionat): ?>
                <li>
                    <a href="visualitzar.php?usuari=<?= $id ?>">
                        <?= $id ?> - <?= $cli['nom'] ?> <?= $cli['cognoms'] ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
