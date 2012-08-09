<?php
include_once '../../includes/conexion.php';

if ($_POST['login'] == '')
    $login = "null";
else
    $login = "'".$_POST['login']."'";

$password = "'".$_POST['password']."'";
$nombres = "'".utf8_decode($_POST['nombre'])."'";
$apellidos = "'".utf8_decode($_POST['apellidos'])."'";
$sexo = "'".$_POST['sexo']."'";
$email = "'".utf8_decode($_POST['email'])."'";
$ciudad = "'".utf8_decode($_POST['ciudad'])."'";
$organizacion = "'".utf8_decode($_POST['organizacion'])."'";
if ($_POST['fnacimiento'] == '' || isset($_POST['fnacimiento'])) {
    $fechanacimiento = "'0000-00-00'";
}else{
    $fechanacimiento = "'".$_POST['fnacimiento']."'";
}
$nivelestudios = "'".$_POST['nivelestudio']."'";
$tipoasistente = "'".$_POST['tipoasistente']."'";
$estado = "'".$_POST['estado']."'";


$sql = "INSERT INTO asistente ( login, passwd, nombrep, apellidos, sexo, mail, ciudad, org, fecha_nac, reg_time, 
id_estudios, id_tasistente, id_estado) 
VALUES ($login, md5($password), $nombres, $apellidos, $sexo, $email, $ciudad, $organizacion, $fechanacimiento, 
CURRENT_TIMESTAMP, $nivelestudios, $tipoasistente, $estado);";

//echo $sql.'<br>';

$conexion = new conexion();
$conexion->insertar($sql);

require_once '../../includes/lib.php';

?>
