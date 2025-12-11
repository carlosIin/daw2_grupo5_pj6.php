<?php
session_start();
require_once "../src/AuthClient.php";

// ✔ COMPROBAR LOGIN USANDO TUS VARIABLES DE SESIÓN REALES
if (!isset($_SESSION["client_user"]) || $_SESSION["role"] !== "client") {
    header("Location: login.php");
    exit;
}

$usuari = $_SESSION["client_user"];
?>

<?php include "../templates/header.php"; ?>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="left">Client</div>

    <div class="right">
        <div class="user-menu">
            <span class="username" onclick="toggleMenu()">
                <?= htmlspecialchars($usuari) ?> ▼
            </span>

            <div class="dropdown" id="dropdown-menu">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bienvenida -->
<h1>Benvingut, <?= htmlspecialchars($usuari) ?></h1>

<!-- MENÚ -->
<div class="menu-options">
    <a href="dades_personals.php">Veure dades personals</a>
    <a href="solicitar_canvi_dades.php">Enviar correu per canvi de dades</a>
    <a href="cistella.php">Gestionar cistella</a>
    <a href="comandes.php">Veure comandes</a>
</div>

<?php include "../templates/footer.php"; ?>

<style>
    .top-bar {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        background: #f0f0f0;
        border-bottom: 1px solid #ccc;
        font-size: 18px;
        font-weight: bold;
    }

    .user-menu {
        position: relative;
        cursor: pointer;
    }

    .username:hover {
        text-decoration: underline;
    }

    .dropdown {
        display: none;
        position: absolute;
        right: 0;
        background: white;
        border: 1px solid #ccc;
        padding: 5px 10px;
        margin-top: 5px;
        z-index: 10;
    }

    .dropdown a {
        text-decoration: none;
        display: block;
        padding: 5px 0;
    }

    .menu-options {
        margin-top: 25px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-size: 20px;
    }

    .menu-options a {
        text-decoration: none;
        color: #333;
    }

    .menu-options a:hover {
        text-decoration: underline;
    }
</style>

<script>
function toggleMenu() {
    const menu = document.getElementById("dropdown-menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
</script>
