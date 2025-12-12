<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$missatge = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $fitxer = RUTA_PRODUCTES . '/productes.json';
    $dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];

    if (isset($dades[$id])) {
        unset($dades[$id]);
        file_put_contents($fitxer, json_encode($dades, JSON_PRETTY_PRINT));

        // Actualitzar còpia per a clients
        $fitxer_copia = __DIR__ . '/../../productes_copia/productes.json';
        file_put_contents($fitxer_copia, json_encode($dades, JSON_PRETTY_PRINT));

        $missatge = "Producte esborrat correctament";
    } else {
        $missatge = "Producte no trobat";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Esborrar producte</title>
</head>
<body>
    <h1>Esborrar producte</h1>
    <?php if($missatge) echo "<p>$missatge</p>"; ?>
    <form method="POST">
        <label>ID del producte a esborrar: <input type="text" name="id" required></label><br><br>
        <button type="submit">Esborrar</button>
    </form>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
