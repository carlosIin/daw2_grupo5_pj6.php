$filename = __DIR__ . '/pdfs/prova.pdf';
$dompdf->stream($filename, ["Attachment" => true]);
