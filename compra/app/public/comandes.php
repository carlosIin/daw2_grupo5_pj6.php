<?php
session_start();

// Validació bàsica
if (!isset($_SESSION["client_user"]) || $_SESSION["role"] !== "client") {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . "/../src/utils.php";
require_once __DIR__ . "/../src/Pedido.php";

$user = $_SESSION["client_user"];

// Carreguem les comandes com a arrays
$ordersData = load_orders($user);

// Transformem cada comanda en un objecte Pedido
$orders = [];
foreach ($ordersData as $data) {
    $orders[] = new Pedido($data);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Comandes</title>
<style>
.topbar {
    background: #f0f0f0;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #ccc;
}
.user-menu {
    position: relative;
    cursor: pointer;
    font-weight: bold;
}
.user-menu-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 22px;
    background: white;
    border: 1px solid #ccc;
}
.user-menu:hover .user-menu-dropdown {
    display: block;
}
</style>
</head>
<body>

<div class="topbar">
    <div><strong>Client</strong></div>
    <div class="user-menu">
        <?= htmlspecialchars($user) ?>
        <div class="user-menu-dropdown">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<h1>Les meves comandes</h1>

<?php if (empty($orders)): ?>

    <p>No tens cap comanda.</p>

<?php else: ?>

    <?php foreach ($orders as $index => $pedido): ?>
        <hr>

        <!-- __toString() de Pedido -->
        <h3><?= htmlspecialchars((string)$pedido) ?></h3>

        <!-- Accés a les propietats via __get -->
        <p><strong>Data:</strong> <?= htmlspecialchars($pedido->data) ?></p>

        <ul>
            <?php foreach ($pedido->items as $item): ?>
                <li>
                    <?= htmlspecialchars($item["nom"]) ?> —
                    <?= htmlspecialchars($item["quantitat"]) ?> unitats
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Veure PDF d'aquesta comanda -->
        <a href="veure_comanda.php?id=<?= $index ?>">Veure PDF</a>

    <?php endforeach; ?>

<?php endif; ?>

<br><br>
<a href="dashboard_cliente.php">Tornar al menú</a>

</body>
</html>
