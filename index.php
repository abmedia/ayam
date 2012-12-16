<?php 
include_once "includes/conf.inc.php";
include_once "includes/lib.php";
imprimeEncabezado();
?>

<p>Gracias por tu interés en <?php echo "$conference_name. ";?> 
Para m&aacute;s informaci&oacute;n del evento, visita <a target="_blank" href="http://www.linuxcampeche.mx/">Linux Campeche</a></p>
    
<p>
    <a href=" <?php echo "$conference_link/ponente/index.php?opc=".NPONENTE; ?>"> Registro de ponentes  </a>  &nbsp;
    <a href=" <?php echo "$conference_link/ponente/"; ?> ">Accede a tu cuenta  </a> <br/>
    Es necesario tu registro, mediante el cual podr&aacute;s enviar  ponencias y estar informado del evento.
</p>
<p>
    <a href=" <?php print "$conference_link/asistente/index.php?opc=new"; ?> "> Registro de asistentes </a> &nbsp;
    <a href=" <?php print "$conference_link/asistente/"; ?>"> Accede a tu cuenta </a> <br/>
    Es necesario tu registro, mediante el cual podr&aacute;s realizar preinscripci&oacute;n al al congreso y  talleres
    además de mantenerte informado del evento.
</p>
 
<p>
    <a href=" <?php print "$conference_link/lista/"; ?> ">Lista preliminar de ponencias</a> <br/>
    Aquí verás las propuestas ponencias que han sido enviadas, y el status en el que se encuentran dichas ponencias.</p>
<p>
    <a href=" <?php print "$conference_link/aceptadas/"; ?> ">Lista de ponencias aceptadas</a>  <br/>
    Aquí verás las ponencias que han sido aceptadas, y que formaran parte del programa final.
</p>

<p>
    <a href="<?php print "$conference_link/programa/"; ?> "> Agenda de actividades </a><br/>
    Aquí verás los eventos y ponencias con las que cuenta el <?php print $conference_name; ?>.
</p>

<p>
    <a href=" <?php print "$conference_link/speakers/"; ?> ">Ponentes que participan en el evento</a> <br/>
    Aquí verás los ponentes que formarn parte del <?php print $conference_name; ?>.
</p>

<p>
    <a href=" <?php print "$conference_link/modalidades/"; ?> "> 
        Modalidades de participacion en la peticion de ponencias
    </a>
    Modalidades de las ponencias que encontraras en el evento <br>
<?php
imprimePie();
?>