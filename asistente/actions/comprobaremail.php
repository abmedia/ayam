<?php
include_once '../../includes/lib.php';
include_once '../../includes/conexion.php';

$conn = new conexion();
$mail = mysql_real_escape_string($_POST['email']);
$sql = "SELECT mail FROM asistente where mail='$mail'";
$rows = $conn->consultarRegistros($sql);
echo $rows;
//echo $mail;
?>