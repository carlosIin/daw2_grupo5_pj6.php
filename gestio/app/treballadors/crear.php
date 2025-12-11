<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador()) {
    echo "Accés denegat";
    exit();
}

// Inicialitzar missatge
$missatge = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_usuari = trim($_POST['usuari'] ?? '');
    $contrasenya = $_POST['contrasenya'] ?? '';
    $tipus = $_POST['tipus'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $cognoms = $_POST['cognoms'] ?? '';
    $adreca = $_POST['adreca'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';

    if ($nom_usuari && $contrasenya && $tipus && $nom && $cognoms && $adreca && $email && $telefon) {
        $fitxer = RUTA_TREBALLADORS . '/treballadors.json';
        $dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];

        // Generar ID nuevo automático
        $id = !empty($dades) ? max(array_keys($dades)) + 1 : 1001;

        // Comprobar si el nom_usuari ya existe
        $existeix = false;
        foreach ($dades as $t) {
            if (isset($t['nom_usuari']) && $t['nom_usuari'] === $nom_usuari) {
                $existeix = true;
                break;
            }
        }

        if (!$existeix) {
            $dades[$id] = [
                'nom_usuari' => $nom_usuari,
                'contrasenya' => password_hash($contrasenya, PASSWORD_DEFAULT),
                'tipus' => $tipus,
                'nom' => $nom,
                'cognoms' => $cognoms,
                'adreca' => $adreca,
                'email' => $email,
                'telefon' => $telefon
            ];
            file_put_contents($fitxer, json_encode($dades, JSON_PRETTY_PRINT));
            $missatge = "Treballador creat correctament!";
        } else {
            $missatge = "Aquest usuari ja existeix";
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
    <title>Crear treballador</title>
</head>
<body>
    <h1>Crear treballador</h1>
    <?php if($missatge) echo "<p>$missatge</p>"; ?>
    <form method="POST">
        <label>Nom usuari: <input type="text" name="usuari" required></label><br><br>
        <label>Contrasenya: <input type="password" name="contrasenya" required></label><br><br>
        <label>Tipus:
            <select name="tipus" required>
                <option value="treballador">Treballador</option>
                <option value="administrador">Administrador</option>
            </select>
        </label><br><br>
        <label>Nom: <input type="text" name="nom" required></label><br><br>
        <label>Cognoms: <input type="text" name="cognoms" required></label><br><br>
        <label>Adreça: <input type="text" name="adreca" required></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Telèfon: <input type="text" name="telefon" required></label><br><br>
        <button type="submit">Crear</button>
    </form>
    <a href="../dashboard_admin.php">Tornar al Dashboard</a>
</body>
</html>
