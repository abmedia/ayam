<?php 
include "../includes/lib.php";

beginSession('P');
session_unset();
session_destroy();

imprimeEncabezado();

#imprimeCajaTop("50","Salida de sesion Ponente");
?>

<center><font face='Arial, Helvetica, sans-serif' size=6>Salida de sesion Ponente</font></center>
<?php 
print '<p><center>Usted ha sido desconectado del sistema.</center></p>'; 
#imprimeCajaBottom();
?>

<center><input type="button" value="Regresar" onClick=location.href="../"></center>

<?php imprimePie();?>
