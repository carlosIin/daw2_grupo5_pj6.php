<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Accés denegat";
    exit();
}

$missatge = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_usuari = $_POST['usuari'] ?? '';
    $contrasenya = $_POST['contrasenya'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $cognoms = $_POST['cognoms'] ?? '';
    $adreca = $_POST['adreca'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $numTargeta = $_POST['numTargeta'] ?? '';
    $ccv = $_POST['ccv'] ?? '';

    if ($nom_usuari && $contrasenya && $nom && $cognoms && $adreca && $email && $telefon && $numTargeta && $ccv) {
        $fitxer_clients = RUTA_CLIENTS . '/clients.json';
        $dades = file_exists($fitxer_clients) ? json_decode(file_get_contents($fitxer_clients), true) : [];

        // Generar ID automático
        $ids = array_keys($dades);
        $nou_id = $ids ? max($ids) + 1 : 2001;

        // Añadir nuevo cliente
        $dades[$nou_id] = [
            'nom_usuari' => $nom_usuari,
            'contrasenya' => password_hash($contrasenya, PASSWORD_DEFAULT),
            'nom' => $nom,
            'cognoms' => $cognoms,
            'adreca' => $adreca,
            'email' => $email,
            'telefon' => $telefon,
            'targeta' => $numTargeta,
            'ccv' => $ccv
        ];

        file_put_contents($fitxer_clients, json_encode($dades, JSON_PRETTY_PRINT));

        // Crear carpeta personal del client
        $carpeta_personal = __DIR__ . '/../../area_clients/' . $nou_id;
        if (!file_exists($carpeta_personal)) {
            mkdir($carpeta_personal, 0770, true);
        }

        // Crear fitxer de dades dins la carpeta personal
        $fitxer_dades = $carpeta_personal . '/dades.json';
        file_put_contents($fitxer_dades, json_encode($dades[$nou_id], JSON_PRETTY_PRINT));

        $missatge = "Client creat correctament";
    } else {
        $missatge = "Cal omplir tots els camps";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear client</title>
</head>
<body>
    <h1>Crear client</h1>
    <?php if($missatge) echo "<p>$missatge</p>"; ?>
    <form method="POST">
        <label>Usuari ID (4 caràcters): <input type="text" name="usuari" maxlength="4" required></label><br><br>
        <label>Contrasenya: <input type="password" name="contrasenya" required></label><br><br>
        <label>Nom: <input type="text" name="nom" required></label><br><br>
        <label>Cognoms: <input type="text" name="cognoms" required></label><br><br>
        <label>Adreça: <input type="text" name="adreca" required></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Telèfon: <input type="text" name="telefon" required></label><br><br>
        <label>Número targeta: <input type="text" name="numTargeta" maxlength="16" required></label><br><br>
        <label>CCV: <input type="text" name="ccv" maxlength="3" required></label><br><br>
        <button type="submit">Crear</button>
    </form>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
