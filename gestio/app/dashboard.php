<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'administrador') {
    header("Location: login.php");
    exit();
}
?>
<h1>Dashboard Administrador</h1>
<p>Usuario: <?= $_SESSION['user'] ?></p>
<ul>
    <li><a href="gestio_trabajadores.php">Gestión de trabajadores</a></li>
    <li><a href="gestio_clientes.php">Gestión de clientes</a></li>
    <li><a href="gestio_productos.php">Gestión de productos</a></li>
    <li><a href="gestio_comandes.php">Gestión de comandes</a></li>
</ul>
<a href="logout.php">Cerrar sesión</a>
