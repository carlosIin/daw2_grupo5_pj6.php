<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$missatge = '';

// Carpetes de comandes
$no_gestionades_dir = __DIR__ . '/../../comandes_no_gestionades';
$gestionades_dir = __DIR__ . '/../../comandes_gestionades';

// Crear carpetes si no existeixen
if (!file_exists($no_gestionades_dir)) mkdir($no_gestionades_dir, 0770, true);
if (!file_exists($gestionades_dir)) mkdir($gestionades_dir, 0770, true);

// Si se recibe un ID de comanda por POST, procesarla
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_comanda = $_POST['id_comanda'] ?? '';

    $fitxer_origen = $no_gestionades_dir . '/' . $id_comanda . '.json';
    $fitxer_destinacio = $gestionades_dir . '/' . $id_comanda . '.json';

    if (file_exists($fitxer_origen)) {
        if (rename($fitxer_origen, $fitxer_destinacio)) {
            $missatge = "Comanda $id_comanda processada correctament.";
        } else {
            $missatge = "Error al processar la comanda $id_comanda.";
        }
    } else {
        $missatge = "Comanda $id_comanda no trobada.";
    }
}

// Llistar totes les comandes no gestionades
$comandes = [];
foreach (glob($no_gestionades_dir . '/*.json') as $fitxer) {
    $nom_fitxer = basename($fitxer, '.json');
    $dades = json_decode(file_get_contents($fitxer), true);
    if ($dades) $comandes[$nom_fitxer] = $dades;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Processar comanda</title>
</head>
<body>
    <h1>Processar comanda</h1>

    <?php if($missatge): ?>
        <p><strong><?php echo $missatge; ?></strong></p>
        <a href="procesar.php">Tornar al menú de comandes</a>
        <hr>
    <?php endif; ?>

    <?php if(count($comandes) === 0): ?>
        <p>No hi ha comandes no gestionades.</p>
        <a href="../dashboard_admin.php">Tornar al Dashboard</a>
    <?php else: ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID Comanda</th>
                <th>Client</th>
                <th>Data</th>
                <th>Acció</th>
            </tr>
            <?php foreach($comandes as $id => $c): ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $c['client']; ?></td>
                <td><?php echo $c['data']; ?></td>
                <td>
                    <form method="POST" style="margin:0;">
                        <input type="hidden" name="id_comanda" value="<?php echo $id; ?>">
                        <button type="submit">Processar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <a href="../dashboard_admin.php">Tornar al Dashboard</a>
    <?php endif; ?>
</body>
</html>
