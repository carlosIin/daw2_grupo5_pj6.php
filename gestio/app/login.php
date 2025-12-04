<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí irá la validación de usuarios
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ejemplo temporal: login por defecto admin
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['user'] = 'admin';
        $_SESSION['role'] = 'administrador';
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Gestión</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        Usuario: <input type="text" name="username" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <input type="submit" value="Entrar">
    </form>
    <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>
