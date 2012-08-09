<?php
include "../includes/lib.php";
include "../includes/conf.inc.php";
include "../includes/Planner.inc.php";

$link = conectaBD();

$fechaQueryE = 'SELECT * FROM fecha_evento ORDER BY fecha';
$fechaRecords = mysql_query($fechaQueryE) or err("No se pudo listar fechas de eventos ".mysql_errno($fechaRecords));

imprimeEncabezado();
?>

<h2 class="elementocentrado">Programa de ponencias del <br> <? print $conference_name ?></h2>
<p class="yacomas_msg">
    Para ver informacion adicional de la ponencia o del ponente haz click en cualquiera de ellos
    <br>
    <small>* Programa sujeto a cambios *</small>
</p>
<hr>
<br>

<?php
$Planner = new Planner($link);
$Planner->load();
echo $Planner->createLegend();
retorno();
$dates = $Planner->getDates();
foreach ($dates AS $date_id => $date) {
    print '<H1 class="elementocentrado">'.strftime_caste("%A %d de %B",strtotime($date['date'])).'</H1>';
    if (!empty($date['descr']))
        print '<H3 class="elementocentrado"> Dia de: '.$date['descr'].'</H3>';
    echo $Planner->createCalendar($date_id);
}
retorno();
echo $Planner->createLegend();
retorno();
retorno();
imprimePie();
?>
