<?php
require_once __DIR__ . "/../src/utils.php";
require_login();

// Dades del client
$user = $_SESSION["client_user"];
$data = get_client_data($user);

// Si no hi ha dades → PDF d'error
if (!$data) {
    $html = "
        <h1>Error en carregar les dades</h1>
        <p>No s'han pogut carregar les teves dades personals.</p>
        <p><a href='dashboard_cliente.php'>Tornar al Dashboard</a></p>
    ";
} else {
    // Generar HTML del PDF
    $html = "
        <h1>Dades personals de $user</h1>
        <ul>
            <li><strong>Nom:</strong> {$data['nom']}</li>
            <li><strong>Cognoms:</strong> {$data['cognoms']}</li>
            <li><strong>Adreça:</strong> {$data['adreca']}</li>
            <li><strong>Email:</strong> {$data['email']}</li>
            <li><strong>Telèfon:</strong> {$data['telefon']}</li>
        </ul>

        <p><a href='dashboard_cliente.php'>Tornar al Dashboard</a></p>
    ";
}

// ─────────────────────────────────────
// GENERAR PDF AMB DOMPDF
// ─────────────────────────────────────
require_once __DIR__ . "/../vendor/autoload.php";

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Enviar PDF al navegador
$dompdf->stream("dades_personals_$user.pdf", ["Attachment" => false]);
exit;
