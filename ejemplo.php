<?php
require_once 'includes/dompdf/dompdf_config.inc.php';

$html= '<img style="width: 75%;" src="images/dompdf_simple.png">';
//echo $html;

$pdf = new DOMPDF();
//$pdf->load_html_file('includes/dompdf/www/test/image.html');
$pdf->load_html($html);
$pdf->render();
$pdf->stream("doc.pdf");

?>
