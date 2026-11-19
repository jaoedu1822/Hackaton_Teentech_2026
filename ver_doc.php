<?php
$permitidos = ['1.pdf', '2.pdf', '3.pdf'];
$arquivo = $_GET['doc'] ?? '';

if (in_array($arquivo, $permitidos, true)) {
    $caminho = __DIR__ . '/documentos/' . $arquivo;
    if (file_exists($caminho)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $arquivo . '"');
        header('Content-Length: ' . filesize($caminho));
        readfile($caminho);
        exit;
    }
}
http_response_code(404);
echo 'Documento não encontrado.';