<?php
require_once __DIR__ . "/../src/utils.php";
session_start();

// Validació de sessió
if (!isset($_SESSION["client_user"]) || $_SESSION["role"] !== "client") {
    header("Location: login.php");
    exit;
}

// -----------------------------------------------------------------------------
// VARIABLES PRINCIPALS
// -----------------------------------------------------------------------------
$user = $_SESSION["client_user"];
$clientsDir = base_clients_dir();
$fitxerCistella = "$clientsDir/$user/cistella.json";
$fitxerProductes = "/var/www/html/botiga/productes_copia/productes_copia";

$missatge = "";

// -----------------------------------------------------------------------------
// CARREGAR PRODUCTES I CISTELLA
// -----------------------------------------------------------------------------
$productes = load_json($fitxerProductes);
$cistella = load_json($fitxerCistella);

// -----------------------------------------------------------------------------
// DETERMINAR MÈTODE (POST, PUT, DELETE)
// -----------------------------------------------------------------------------
$method = $_POST["_method"] ?? "POST";

// -----------------------------------------------------------------------------
// GESTIÓ DELETE: ESBORRAR CISTELLA
// -----------------------------------------------------------------------------
if ($method === "DELETE") {

    if (file_exists($fitxerCistella)) {
        unlink($fitxerCistella);
    }

    $cistella = [];
    $missatge = "Cistella eliminada correctament.";
}

// -----------------------------------------------------------------------------
// GESTIÓ PUT: ACTUALITZAR QUANTITATS
// -----------------------------------------------------------------------------
else if ($method === "PUT") {

    $quantitats = $_POST["qty"] ?? [];
    $novaCistella = [];

    foreach ($productes as $prod) {
        $id = $prod["id"];
        $q = isset($quantitats[$id]) ? (int)$quantitats[$id] : 0;

        if ($q > 0) {
            $prod["quantitat"] = $q;
            $novaCistella[] = $prod;
        }
    }

    save_json($fitxerCistella, $novaCistella);
    $cistella = $novaCistella;
    $missatge = "Cistella actualitzada (PUT).";
}

// -----------------------------------------------------------------------------
// GESTIÓ POST: CONFIRMAR COMPRA (CREAR COMANDA)
// -----------------------------------------------------------------------------
else if ($method === "POST") {

    $quantitats = $_POST["qty"] ?? [];
    $novaCistella = [];

    foreach ($productes as $prod) {
        $id = $prod["id"];
        $q = isset($quantitats[$id]) ? (int)$quantitats[$id] : 0;

        if ($q > 0) {
            $prod["quantitat"] = $q;
            $novaCistella[] = $prod;
        }
    }

    if (!empty($novaCistella)) {
        // Crear comanda
        $order = [
            "data" => date("Y-m-d H:i:s"),
            "items" => $novaCistella
        ];

        save_order($user, $order);

        // Eliminar cistella després de compra
        if (file_exists($fitxerCistella)) {
            unlink($fitxerCistella);
        }

        $missatge = "Comanda creada correctament!";
        $cistella = [];

    } else {
        $missatge = "No hi ha productes seleccionats.";
    }
}

// -----------------------------------------------------------------------------
// QUANTITATS PER MOSTRAR EN EL FORMULARI
// -----------------------------------------------------------------------------
$quantitatsActuals = [];
foreach ($cistella as $item) {
    $quantitatsActuals[$item["id"]] = $item["quantitat"];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cistella</title>
</head>
<body>

<!-- ⭐ HEADER INTEGRAT (TOP BAR) -->
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

<h1>Gestionar cistella</h1>

<?php if ($missatge): ?>
    <p style="color:green;"><strong><?= htmlspecialchars($missatge) ?></strong></p>
<?php endif; ?>

<!-- ⭐ FORMULARI GENERAL DE LA CISTELLA (PER PUT I POST) -->
<form method="POST">

    <!-- Per defecte PUT (actualitzar quantitats) -->
    <input type="hidden" name="_method" value="PUT">

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Producte</th>
            <th>Preu</th>
            <th>Quantitat</th>
        </tr>

        <?php foreach ($productes as $p): 
            $id = $p["id"];
            $q = $quantitatsActuals[$id] ?? 0;
        ?>
            <tr>
                <td><?= htmlspecialchars($p["id"]) ?></td>
                <td><?= htmlspecialchars($p["nom"]) ?></td>
                <td><?= htmlspecialchars($p["preu"]) ?> €</td>
                <td>
                    <input type="number" name="qty[<?= htmlspecialchars($id) ?>]" min="0" value="<?= $q ?>">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <!-- ⭐ BOTO PUT (actualitzar cistella) -->
    <button type="submit">Actualitzar cistella (PUT)</button>

    <!-- ⭐ BOTO POST (confirmar compra) -->
    <button type="submit" onclick="this.form._method.value='POST'">
        Confirmar compra (POST)
    </button>

    <!-- ⭐ BOTO DELETE (esborrar cistella) -->
    <button type="submit" onclick="this.form._method.value='DELETE'">
        Eliminar cistella (DELETE)
    </button>
</form>

<br>
<a href="dashboard_cliente.php">Tornar al menú</a>

</body>
</html>
