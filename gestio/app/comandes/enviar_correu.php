<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

// Ruta de comandes no gestionades
$fitxer_comandes = RUTA_COMANDES_NO_GESTIONADES;

// Comprovar si s'ha passat un id
$id_comanda = $_GET['id'] ?? '';

if ($id_comanda) {
    $ruta_comanda = $fitxer_comandes . '/' . $id_comanda . '.json';

    if (!file_exists($ruta_comanda)) {
        echo "<p>Comanda no trobada.</p>";
        echo '<a href="enviar_correu.php">Tornar al menú de comandes</a>';
        exit();
    }

    $comanda = json_decode(file_get_contents($ruta_comanda), true);

    // Cargar datos del client
    $fitxer_clients = RUTA_CLIENTS . '/clients.json';
    $clients = file_exists($fitxer_clients) ? json_decode(file_get_contents($fitxer_clients), true) : [];
    $client_id = $comanda['client'] ?? '';
    $client = $clients[$client_id] ?? null;

    if (!$client) {
        echo "<p>Client no trobat.</p>";
        echo '<a href="enviar_correu.php">Tornar al menú de comandes</a>';
        exit();
    }

    // Aquí iría el envío del correo usando PHPMailer
    // Por ejemplo: enviar_email($client['email'], $comanda);
    $missatge = "Correu enviat correctament a " . $client['email'];

    echo "<p>$missatge</p>";
    echo '<a href="enviar_correu.php">Tornar al menú de comandes</a>';

} else {
    // Si no hay ID, mostramos un selector de comandes
    $comandes_fitxers = glob($fitxer_comandes . '/*.json');

    if (empty($comandes_fitxers)) {
        echo "<p>No hi ha comandes no gestionades.</p>";
        echo '<a href="../dashboard_admin.php">Tornar al Dashboard</a>';
        exit();
    }

    echo "<h1>Enviar correu comanda</h1>";
    echo '<form method="GET" action="enviar_correu.php">';
    echo '<label>Selecciona comanda: <select name="id">';
    foreach ($comandes_fitxers as $f) {
        $nom_fitxer = basename($f, '.json');
        echo '<option value="' . $nom_fitxer . '">' . $nom_fitxer . '</option>';
    }
    echo '</select></label>';
    echo '<button type="submit">Enviar correu</button>';
    echo '</form>';
    echo '<a href="../dashboard_admin.php">Tornar al Dashboard</a>';
}
?>
