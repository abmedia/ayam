<?php
//Incluyendo e inicializando funciones para conexión de bd y variables.
include_once "../includes/lib.php";
include_once "../includes/conf.inc.php";
include_once "../includes/conexion.php";
require 'ficharegistro.php';

beginSession('A');
$idasistente = $_SESSION['YACOMASVARS']['asiid'];
$conexion = new conexion();
$query = "SELECT login, nombrep, apellidos FROM asistente WHERE id = $idasistente;";
$result = $conexion->consultar($query);
?>
<div>
    <label>Nickname: </label> <?php echo $result['login']; ?><br>
    <label>Nombre: </label> <?php echo $result['nombrep']; ?>
    <label>Apellidos: </label> <?php echo $result['apellidos']; ?><br>
</div>

<?php
$conexion->closeResult($result);
if (isset($result)) { echo 'existe<br>';} else { echo 'nan';}

$pdf = new ficharegistro();
$pdf->AddPage();
$pdf->SetFont("Arial");
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Imprimiendo línea número '.$i,0,1);
$pdf->Output();
?>