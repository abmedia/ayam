<?php 
//include_once "../includes/conf.inc.php";
if (isset($_GET['opc']))
    switch ($_GET['opc']){
        case "new": include "hojaregistro.php";
        break;
    }
else
    include "signin.php";
?>
