<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$usuari_seleccionat = $_GET['usuari'] ?? '';
$fitxer_clients = RUTA_CLIENTS . '/clients.json';
$dades = file_exists($fitxer_clients) ? json_decode(file_get_contents($fitxer_clients), true) : [];

if ($usuari_seleccionat && isset($dades[$usuari_seleccionat])) {
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
    <?php
    if(isset($error)) {
        echo "<p>$error</p>";
    } else {
        echo "<p><strong>Usuari:</strong> $usuari_seleccionat</p>";
        echo "<p><strong>Nom:</strong> {$client['nom']} {$client['cognoms']}</p>";
        echo "<p><strong>Adreça:</strong> {$client['adreca']}</p>";
        echo "<p><strong>Email:</strong> {$client['email']}</p>";
        echo "<p><strong>Telèfon:</strong> {$client['telefon']}</p>";
        echo "<p><strong>Número targeta:</strong> {$client['numTargeta']}</p>";
        echo "<p><strong>CCV:</strong> {$client['ccv']}</p>";
    }
    ?>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
