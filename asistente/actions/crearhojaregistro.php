<?php
require_once '../../includes/dompdf/dompdf_config.inc.php';
echo $_GET['html'];
/*
$pdf = new DOMPDF();
$pdf->load_html($_GET['html']);
$pdf->render();
$pdf->stream('hoja.pdf')
*/
?>
