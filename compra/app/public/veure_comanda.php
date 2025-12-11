<?php
session_start();

// Validació bàsica
if (!isset($_SESSION["client_user"]) || $_SESSION["role"] !== "client") {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . "/../src/utils.php";
require_once __DIR__ . "/../vendor/autoload.php";

use Dompdf\Dompdf;

$user = $_SESSION["client_user"];

$id = $_GET["id"] ?? null;
$orders = load_orders($user);

if ($id === null || !isset($orders[$id])) {
    echo "Comanda no trobada.";
    echo "<br><a href='comandes.php'>Tornar</a>";
    exit;
}

$order = $orders[$id];

// -----------------------------------------------------------------------------
// GENERACIÓ PDF
// -----------------------------------------------------------------------------
$html = "<h1>Comanda del client: $user</h1>";
$html .= "<p>Data: " . htmlspecialchars($order["data"]) . "</p>";

$html .= "<h2>Productes</h2><ul>";

$total = 0;

foreach ($order["items"] as $item) {
    $preu = $item["preu"];
    $quant = $item["quantitat"];
    $subtotal = $preu * $quant;
    $total += $subtotal;

    $html .= "<li>{$item['nom']} - {$quant} unitats - {$subtotal} €</li>";
}

$iva = $total * 0.21;
$totalFinal = $total + $iva;

$html .= "</ul>";
$html .= "<p><strong>Subtotal:</strong> $total €</p>";
$html .= "<p><strong>IVA (21%):</strong> $iva €</p>";
$html .= "<p><strong>Total final:</strong> $totalFinal €</p>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();

$dompdf->stream("comanda_$id.pdf", ["Attachment" => false]);
