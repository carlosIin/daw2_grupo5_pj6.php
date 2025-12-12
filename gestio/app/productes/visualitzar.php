<?php
require_once '../config.php';
verificar_sessio();

if (!es_administrador() && !es_treballador()) {
    exit("Acces denegat");
}

// Cargar FPDF
require_once '../lib/fpdf/fpdf.php';

// Cargar productos
$fitxer = RUTA_PRODUCTES . '/productes.json';
$dades = file_exists($fitxer) ? json_decode(file_get_contents($fitxer), true) : [];

if (empty($dades)) {
    exit("No hi ha productes disponibles. Torna al menu de gestio de productes: <a href='../dashboard_admin.php'>Dashboard</a>");
}

// Crear PDF
$pdf = new FPDF();
$pdf->SetFont('Arial','',12);

foreach ($dades as $producte) {
    $pdf->AddPage();

    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,'Dades del Producte',0,1,'C');

    $pdf->SetFont('Arial','',12);
    $pdf->Ln(5);

    // Evitar caracteres especiales y acentos
    $nom = mb_convert_encoding($producte['nom'], 'ISO-8859-1', 'UTF-8');
    $nom = str_replace('$','', $nom); // Quitar el signo $

    $pdf->Cell(50,10,'ID:',0,0);
    $pdf->Cell(0,10,$producte['id'],0,1);

    $pdf->Cell(50,10,'Nom:',0,0);
    $pdf->Cell(0,10,$nom,0,1);

    $pdf->Cell(50,10,'Preu:',0,0);
    $pdf->Cell(0,10,$producte['preu'].' EUR',0,1);

    $pdf->Ln(10);
    $pdf->SetFont('Arial','I',10);
    $pdf->Cell(0,10,'Tornar al menu de gestio de productes',0,1,'C', false, '../dashboard_admin.php');
}

// Enviar PDF al navegador
$pdf->Output('I','productes.pdf');
exit();
