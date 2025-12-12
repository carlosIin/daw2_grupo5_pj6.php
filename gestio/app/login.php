<?php
session_start();

// Carrega configuració general
require_once 'config.php';

// Carrega funcions que llegeixen JSON
require_once '../treballadors/llista.php';
require_once '../clients/llista.php';

// Missatge d’error inicial
$missatge_error = '';

// Carreguem dades des dels JSON
$treballadors = carregar_treballadors();
$clients = carregar_clients();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuari = trim($_POST['usuari'] ?? '');
    $contrasenya = $_POST['contrasenya'] ?? '';

    // ---------- LOGIN TREBALLADORS/ADMIN ----------
    foreach ($treballadors as $id => $t) {
        if ($t['nom_usuari'] === $usuari && password_verify($contrasenya, $t['contrasenya'])) {

            $_SESSION['usuari'] = $usuari;
            $_SESSION['tipus'] = $t['tipus'];

            if ($t['tipus'] === 'administrador') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_treballador.php");
            }

            exit();
        }
    }

    // ---------- LOGIN CLIENT ----------
    foreach ($clients as $id => $c) {
        if ($c['nom_usuari'] === $usuari && password_verify($contrasenya, $c['contrasenya'])) {

            $_SESSION['usuari'] = $usuari;
            $_SESSION['tipus'] = "client";

            header("Location: dashboard_client.php");
            exit();
        }
    }

    // SI NO ÉS TREBALLADOR NI CLIENT → ERROR
    $missatge_error = "Usuari o contrasenya incorrectes";
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Inici de sessió</title>
</head>
<body>
    <h1>Accés usuaris</h1>

    <?php if ($missatge_error): ?>
        <p style="color:red;"><?php echo $missatge_error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Usuari:</label>
        <input type="text" name="usuari" required><br><br>

        <label>Contrasenya:</label>
        <input type="password" name="contrasenya" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <br>
    <a href="index.php">Tornar a l'inici</a>
</body>
</html>

