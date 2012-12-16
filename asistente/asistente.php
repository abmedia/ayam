<?php 
//include_once "../includes/conf.inc.php";
switch ($_GET['opc']) {
    case "actualizar": include "Masistente.php";
        break;
    case "calendario": include "planner.php";
        break;
    case "talleres": include "Ltalleres.php";
        break;
    case "inscribirse": include "Ltalleres-reg.php";
        break;
    case "encuesta": include "encuesta.php";
        break;
    case "hoja": include "HojaRegistro.php";
        break;
    case "imprimirficha": include "crearficharegistro.php";
        break;
}
?>