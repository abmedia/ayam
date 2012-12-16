<?php  
include_once "../includes/lib.php";
include_once "../includes/conf.inc.php";
beginSession('A');
imprimeEncabezado();

$link=conectaBD();
$idponente=$_SESSION['YACOMASVARS']['asiid'];
$userQuery = 'SELECT nombrep,apellidos FROM asistente WHERE id="'.$idponente.'"';
$userRecords = mysql_query($userQuery) or err("No se pudo checar el login asistente".mysql_errno($userRecords));
$p = mysql_fetch_array($userRecords);
$msg='Asistentes<br><small>Bienvenido '.stripslashes($p['nombrep']).' '.stripslashes($p['apellidos']).'</small>';

print '<P class="yacomas_login">Login: '.$_SESSION['YACOMASVARS']['asilogin'].'&nbsp;<a class="precaucion" href=signout.php>Desconectarme</a></P>';
//imprimeCajaTop("100",$msg);
print '<hr>';
?>
<br>
<div class="formcontainer"><a href="asistente.php?opc=actualizar">Modificar mis datos</a></div>
<div class="formcontainer"><a href="asistente.php?opc=calendario">Agenda de Actividades</a></div>
<div class="formcontainer"><a href="asistente.php?opc=talleres">Listar/Inscribirme a talleres y tutoriales</a></div>
<div class="formcontainer"><a href="asistente.php?opc=inscribirse">Listar/Darme de baja de talleres y tutoriales registrados</a></div>
<div class="formcontainer"><a href="asistente.php?opc=hoja">Imprimir hoja de registro</a></div>


<?php
//print '<a href="asistente.php?opc='.ENCUESTA.'">Encuestas </a> <br><br>';
imprimePie();
?>
