<?php
require_once '../config.php';
require_once '../lib/fpdf/fpdf.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    echo "Acces denegat";
    exit();
}

$fitxer_comandes = __DIR__ . '/../../comandes_no_gestionades';
$fitxer_clients = RUTA_CLIENTS . '/clients.json';
$clients = file_exists($fitxer_clients) ? json_decode(file_get_contents($fitxer_clients), true) : [];

// Carpeta para PDFs
$carpeta_pdfs = __DIR__ . '/../../comandes_pdf';
if (!file_exists($carpeta_pdfs)) {
    mkdir($carpeta_pdfs, 0770, true);
}

// Obtener todos los JSON de comandes no gestionades
$files = glob($fitxer_comandes . '/*.json');

if (!$files) {
    echo "<p>No hi ha comandes no gestionades.</p>";
    echo '<a href="../dashboard_admin.php">Tornar al menú de comandes</a>';
    exit();
}

// Generar PDF por cada comanda
$pdf_links = [];
foreach ($files as $file) {
    $data_comanda = json_decode(file_get_contents($file), true);
    if (!$data_comanda) continue;

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Comanda: ' . $data_comanda['id_comanda'], 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, 'Data: ' . $data_comanda['data'], 0, 1);

    $client_id = $data_comanda['client'];
    $client_nom = $clients[$client_id]['nom'] ?? $client_id;
    $client_cognoms = $clients[$client_id]['cognoms'] ?? '';
    $pdf->Cell(0, 8, 'Client: ' . $client_nom . ' ' . $client_cognoms, 0, 1);

    $pdf->Cell(0, 8, 'Estat: ' . $data_comanda['estat'], 0, 1);
    $pdf->Ln(5);

    $pdf->Cell(60, 8, 'Producte', 1);
    $pdf->Cell(30, 8, 'Quantitat', 1);
    $pdf->Cell(30, 8, 'Preu', 1);
    $pdf->Cell(30, 8, 'Total', 1);
    $pdf->Ln();

    $total_comanda = 0;
    foreach ($data_comanda['productes'] as $p) {
        $subtotal = $p['quantitat'] * $p['preu'];
        $total_comanda += $subtotal;

        $pdf->Cell(60, 8, $p['nom'], 1);
        $pdf->Cell(30, 8, $p['quantitat'], 1);
        $pdf->Cell(30, 8, $p['preu'], 1);
        $pdf->Cell(30, 8, $subtotal, 1);
        $pdf->Ln();
    }

    $pdf->Ln(5);
    $pdf->Cell(0, 8, 'Total comanda: ' . $total_comanda, 0, 1);

    // Guardar PDF en servidor
    $pdf_filename = $carpeta_pdfs . '/' . $data_comanda['id_comanda'] . '.pdf';
    $pdf->Output('F', $pdf_filename);

    // Guardar enlace para mostrar en pantalla
    $pdf_links[] = $pdf_filename;
}

// Mostrar enlaces a PDFs
echo "<h1>Comandes no gestionades</h1>";
echo "<ul>";
foreach ($pdf_links as $link) {
    $nom_fitxer = basename($link);
    echo "<li><a href='../../comandes_pdf/$nom_fitxer' target='_blank'>$nom_fitxer</a></li>";
}
echo "</ul>";

echo '<a href="../dashboard_admin.php">Tornar al menú de comandes</a>';
?>
