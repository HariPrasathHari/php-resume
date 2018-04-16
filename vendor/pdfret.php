<?php
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

$mpdf->Bookmark('Start of the document');
$mpdf->WriteHTML('<div>Section 1 text</div>');

$mpdf->Output();
?>