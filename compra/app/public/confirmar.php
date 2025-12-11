<?php
require_once __DIR__ . "/../src/utils.php";
require_login();

$user = get_current_username();
$cistella = load_basket($user);

if (empty($cistella)) {
    echo "<h1>La cistella està buida!</h1>";
    echo "<p><a href='cistella.php'>Tornar</a></p>";
    exit;
}

$subtotal = 0;
foreach ($cistella as $item) {
    $subtotal += $item["preu"] * $item["quantitat"];
}
$iva   = $subtotal * 0.21;
$total = $subtotal + $iva;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $order = [
        "data" => date("Y-m-d H:i:s"),
        "items" => $cistella,
        "subtotal" => $subtotal,
        "iva" => $iva,
        "total" => $total
    ];

    save_order($user, $order);
    save_basket($user, []);

    header("Location: comandes.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Confirmar compra</title>
</head>
<body>

<?php
$user = $_SESSION["client_user"] ?? "Usuari";
?>
<style>
.topbar {
    background: #f0f0f0;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
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
    padding: 5px;
}
.user-menu:hover .user-menu-dropdown {
    display: block;
}
</style>

<div class="topbar">
    <div><strong>Client</strong></div>
    <div class="user-menu">
        <?= htmlspecialchars($user) ?>
        <div class="user-menu-dropdown">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<h1>Resum de la compra</h1>

<table border="1" cellpadding="5" cellspacing="0">
<tr><th>Producte</th><th>Quantitat</th><th>Preu</th><th>Subtotal</th></tr>

<?php foreach ($cistella as $item): 
    $s = $item["preu"] * $item["quantitat"];
?>
<tr>
    <td><?= $item["nom"] ?></td>
    <td><?= $item["quantitat"] ?></td>
    <td><?= number_format($item["preu"],2) ?> €</td>
    <td><?= number_format($s,2) ?> €</td>
</tr>
<?php endforeach; ?>
</table>

<p>Subtotal: <?= number_format($subtotal,2) ?> €</p>
<p>IVA (21%): <?= number_format($iva,2) ?> €</p>
<p><strong>Total: <?= number_format($total,2) ?> €</strong></p>

<a href="cistella.php">Tornar a la cistella</a>

<form method="POST">
<button type="submit">Confirmar compra</button>
</form>

</body>
</html>
