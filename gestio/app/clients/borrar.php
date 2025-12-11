<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$missatge = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuari = $_POST['usuari'] ?? '';
    $fitxer_clients = RUTA_CLIENTS . '/clients.json';
    $dades = file_exists($fitxer_clients) ? json_decode(file_get_contents($fitxer_clients), true) : [];

    if (isset($dades[$usuari])) {
        unset($dades[$usuari]);
        file_put_contents($fitxer_clients, json_encode($dades, JSON_PRETTY_PRINT));

        // Esborrar carpeta personal
        $carpeta_personal = __DIR__ . '/../../area_clients/' . $usuari;
        if (file_exists($carpeta_personal)) {
            array_map('unlink', glob("$carpeta_personal/*.*"));
            rmdir($carpeta_personal);
        }

        $missatge = "Client esborrat correctament";
    } else {
        $missatge = "Usuari no trobat";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Esborrar client</title>
</head>
<body>
    <h1>Esborrar client</h1>
    <?php if($missatge) echo "<p>$missatge</p>"; ?>
    <form method="POST">
        <label>Usuari a esborrar: <input type="text" name="usuari" required></label><br><br>
        <button type="submit">Esborrar</button>
    </form>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
