<?php
require_once __DIR__ . "/../src/utils.php";

// Tancar sessió completament
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();

// Tornar al login
header("Location: /login.php");
exit;
