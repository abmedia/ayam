<?php
include_once '../../includes/lib.php';
include_once '../../includes/conexion.php';

$sql = "SELECT login FROM asistente where login= '".$_GET['login']."' ";
//echo $sql;
$conn = new conexion();
$rows = $conn->consultarRegistros($sql);
echo $rows;
?>