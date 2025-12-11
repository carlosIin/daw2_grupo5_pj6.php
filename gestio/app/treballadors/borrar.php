<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador()) {
    echo "Accés denegat";
    exit();
}

$missatge = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuari = $_POST['usuari'] ?? '';
    $fitxer = RUTA_TREBALLADORS . '/treballadors.json';
    $dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];

    if (isset($dades[$usuari])) {
        unset($dades[$usuari]);
        file_put_contents($fitxer, json_encode($dades, JSON_PRETTY_PRINT));
        $missatge = "Treballador esborrat correctament";
    } else {
        $missatge = "Usuari no trobat";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Esborrar treballador</title>
</head>
<body>
    <h1>Esborrar treballador</h1>
    <?php if($missatge) echo "<p>$missatge</p>"; ?>
    <form method="POST">
        <label>Usuari a esborrar: <input type="text" name="usuari" required></label><br><br>
        <button type="submit">Esborrar</button>
    </form>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
