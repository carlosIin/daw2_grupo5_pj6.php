<?php
require_once __DIR__ . "/../src/utils.php";
require_once __DIR__ . "/../src/AuthClient.php";

$error = "";
$auth = new AuthClient();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $_POST["username"];
    $pass = $_POST["password"];

    if ($auth->login($user, $pass)) {

        if (ob_get_length()) ob_end_clean();

        header("Location: ./dashboard_cliente.php");
        exit;
    }

    $error = "Usuari o contrasenya incorrectes";
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Clients</title>
</head>
<body>

<h1>Login Clients</h1>

<form method="POST">
    Usuari: <input name="username" required><br>
    Contrasenya: <input type="password" name="password" required><br>
    <button type="submit">Entrar</button>
</form>

<p style="color:red;"><?= $error ?></p>
<p><a href="index.php">Tornar</a></p>

</body>
</html>
