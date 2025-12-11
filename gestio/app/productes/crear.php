<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$missatge = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $preu = $_POST['preu'] ?? '';

    if ($id && $nom && $preu) {
        // Asegurarse de que la carpeta existe
        if (!is_dir(RUTA_PRODUCTES)) {
            mkdir(RUTA_PRODUCTES, 0770, true);
        }

        $fitxer = RUTA_PRODUCTES . '/productes.json';
        $dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];

        if (!isset($dades[$id])) {
            $dades[$id] = [
                'id' => $id,
                'nom' => $nom,
                'preu' => floatval($preu)
            ];
            file_put_contents($fitxer, json_encode($dades, JSON_PRETTY_PRINT));

            // Crear carpeta y copia para clientes
            $copia_dir = __DIR__ . '/../../productes_copia';
            if (!is_dir($copia_dir)) {
                mkdir($copia_dir, 0770, true);
            }
            $fitxer_copia = $copia_dir . '/productes.json';
            file_put_contents($fitxer_copia, json_encode($dades, JSON_PRETTY_PRINT));

            $missatge = "Producte creat correctament";
        } else {
            $missatge = "Aquest identificador ja existeix";
        }
    } else {
        $missatge = "Cal omplir tots els camps";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear producte</title>
</head>
<body>
    <h1>Crear producte</h1>
    <?php if($missatge) echo "<p>$missatge</p>"; ?>
    <form method="POST">
        <label>ID (4 digits): <input type="text" name="id" maxlength="4" required></label><br><br>
        <label>Nom: <input type="text" name="nom" required></label><br><br>
        <label>Preu: <input type="number" step="0.01" name="preu" required></label><br><br>
        <button type="submit">Crear</button>
    </form>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>

