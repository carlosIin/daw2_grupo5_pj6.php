<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

// Cargar productos
$fitxer = RUTA_PRODUCTES . '/productes.json';
$dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];

// Producto a mostrar
$id_mostrar = $_GET['id'] ?? null;
$index_mostrar = 0; // por defecto el primero

if ($id_mostrar !== null) {
    // Buscar índice del producto con ese id
    foreach ($dades as $i => $p) {
        if ($p['id'] == $id_mostrar) {
            $index_mostrar = $i;
            break;
        }
    }
}

if (isset($dades[$index_mostrar])) {
    $producte = $dades[$index_mostrar];
} else {
    $error = "Producte no trobat";
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Visualitzar producte</title>
</head>
<body>
    <h1>Visualitzar producte</h1>

    <?php if(isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php else: ?>
        <h2>Producte seleccionat</h2>
        <p><strong>ID:</strong> <?php echo $producte['id']; ?></p>
        <p><strong>Nom:</strong> <?php echo $producte['nom']; ?></p>
        <p><strong>Preu:</strong> <?php echo $producte['preu']; ?> €</p>

        <hr>
        <h3>Altres productes</h3>
        <ul>
            <?php foreach($dades as $i => $p): ?>
                <?php if($i != $index_mostrar): ?>
                    <li>
                        <a href="?id=<?php echo $p['id']; ?>">
                            <?php echo $p['nom']; ?> (<?php echo $p['id']; ?>)
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
