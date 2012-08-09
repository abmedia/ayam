<?php  
include_once "../includes/lib.php";
include_once "../includes/conf.inc.php";
require_once '../includes/dompdf/dompdf_config.inc.php';
beginSession('A');
//imprimeEncabezadoR();

$idasistente=$_SESSION['YACOMASVARS']['asiid'];
$link=conectaBD();

//
// Status 7 es Eliminado
// Seleccionamos todos los que no esten eliminados
// Tal vez podriamos mejorar esta cosa para no depender directamente de que el status siempre sea 
// dado en el codigo
//

$userQueryP='	SELECT 	AI.reg_time, 
			F.fecha, 
			N.descr AS nivel, 
			PO.nombrep, 
			PO.apellidos, 
			P.nombre AS taller, 
			O.descr AS orientacion, 
			EO.hora, 
			P.duracion, 
			PT.descr AS prop_tipo,
			L.nombre_lug 
		FROM 	fecha_evento AS F, 
			ponente AS PO, 
			lugar AS L, 
			orientacion AS O, 
			inscribe AS AI, 
			evento AS E, 
			propuesta AS P, 
			evento_ocupa AS EO, 
			prop_tipo AS PT,
			prop_nivel AS N  
		WHERE 	EO.id_fecha=F.id AND 
			AI.id_evento=E.id AND 
			E.id_propuesta=P.id AND 
			AI.id_evento=EO.id_evento AND 
			P.id_orientacion=O.id AND 
			EO.id_lugar=L.id AND 
			P.id_ponente=PO.id AND 
			P.id_nivel=N.id AND 
			P.id_prop_tipo=PT.id AND
			AI.id_asistente="'.$idasistente.'" 
		GROUP BY AI.id_evento 
		ORDER BY F.fecha, AI.id_evento, EO.hora';
$userRecordsP = mysql_query($userQueryP) or err('No se pudo listar talleres del asistente'.mysql_errno($userRecords));

$imagen = '<img src="flisol1.jpg">';
$html = '<div id="formaregistro">';
$html = '<div style=" margin: auto; background-color: orange;">
        <table width="100%">
        <tr>
            <td>'.$imagen.'</td>
            <td width="45%" align="right">
            <p style="color: white">
                <b>Campeche 2012</b><br>
                26 de Mayo<br>
                ITESM Sede Campeche<br>
            </p>
            </td>
        </tr>
        </table>    
        </div>';
$html = $html.'<br>
    <div style="width: 400px; margin: auto">
    <p>Esta hoja, te servir&aacute; para asistir a cualquier conferencia
    y/o pl&aacute;tica, adem&aacute;s de los talleres que tengas registrados.</p<>
    </div><br><br>';

$userQuery = "SELECT nombrep, apellidos, mail, sexo, id_tasistente, id_estudios, id_estado, org, ciudad FROM asistente WHERE id='$idasistente'";
$userRecords = mysql_query($userQuery) or err("Asistente no encontrado.".mysql_errno($userRecords));
$p = mysql_fetch_array($userRecords);

// Inicio datos de Ponencias

$html = $html.'<table align="center">
            <tr>
                <td class="name">Nombre Completo: </td>
		<td class="resultado">'.$p["nombrep"].' '.$p['apellidos'].'</td>
            </tr>
            <tr>
		<td class="name">Correo Electr&oacute;nico: </td>
		<td class="resultado">'.$p["mail"].'</td>
            </tr>
            <tr>
		<td class="name">Sexo: </td>
		<td class="resultado">';
		if ($p['sexo']=="M")
		    $html = $html."Masculino</td>";
		else
		    $html = $html."Femenino</td>";
		    
$html = $html.'</tr>
            <tr>
                <td class="name">Organizaci&oacute;n: </td>
		<td class="resultado">'.stripslashes($p['org']).'</td>
            </tr>
            <tr>
		<td class="name">Estudios: </td>
		<td class="resultado">';
		$query = 'SELECT descr FROM estudios WHERE id="'.$p['id_estudios'].'"';
		$result=mysql_query($query);
	 	while($fila=mysql_fetch_array($result)) {
                     $html = $html.sprintf ("%s",$fila["descr"]);
  		}
		mysql_free_result($result);
$html = $html. '</td>
            </tr>
            <tr>
                <td class="name">Tipo Asistente:  </td>
		<td class="resultado">';
		$query = 'SELECT descr FROM tasistente WHERE id="'.$p['id_tasistente'].'"';
		$result=mysql_query($query);
	 	while($fila=mysql_fetch_array($result)) {
			$html = $html.sprintf ("%s",$fila["descr"]);
  		}
		mysql_free_result($result);
$html = $html.'</td>
            </tr>
            <tr>
                <td class="name">Ciudad: </td>
		<td class="resultado">'.$p['ciudad'].'</td>
            </tr>
            <tr>
                <td class="name">Provincia: </td>
		<td class="resultado">';
		$query= "select descr from estado where id='".$p['id_estado']."'";
		$result=mysql_query($query);
 		while($fila=mysql_fetch_array($result)) {
			$html = $html.sprintf ("%s",$fila["descr"]);
  		}
		mysql_free_result($result);
$html = $html.'</td>
            </tr>
        </table>
        <p><hr></p>';

// Fin datos de usuario
// Inicio datos de Talleres inscritos 
$talleres = '<p class="yacomas_error">Talleres y/o Tutoriales Inscritos</p>';

$talleres = $talleres.' <table border="0" align=center width="100%">
	<tr>
	<td bgcolor='.$colortitle.' class="elementocentrado"><b>Taller/Tutorial</b></td>
	<td bgcolor='.$colortitle.' class="elementocentrado"><b>Orientaci&oacute;n</b></td>
	<td bgcolor='.$colortitle.' class="elementocentrado"><b>Fecha</b></td>
	<td bgcolor='.$colortitle.' class="elementocentrado"><b>Hora</b></td>
	<td bgcolor='.$colortitle.' class="elementocentrado"><b>Lugar</b></td>
	<td bgcolor='.$colortitle.' class="elementocentrado"><b>Fecha Inscripci&oacute;n</b></td>
	</tr>';

	$color=1;
	while ($fila = mysql_fetch_array($userRecordsP))
	{
		if ($color==1) 
		{
			$bgcolor=$color_renglon1;
			$color=2;
		}
		else 
		{
			$bgcolor=$color_renglon2;
			$color=1;
		}
		$talleres = $talleres.'<tr>';
		$talleres = $talleres. '</td><td bgcolor='.$bgcolor.'>'.$fila["taller"];
		$talleres = $talleres. '<small> ('.$fila["prop_tipo"].')</small>';
		$talleres = $talleres. '<br><small>'.$fila["nombrep"].' '.$fila["apellidos"].'</small>';
		$talleres = $talleres. '</td><td bgcolor='.$bgcolor.'>'.$fila["orientacion"];
		$talleres = $talleres. '</td><td bgcolor='.$bgcolor.'>'.$fila["fecha"];
		$talleres = $talleres. '</td><td bgcolor='.$bgcolor.'>'.$fila["hora"].':00 - ';
		$hfin=$fila["hora"]+$fila["duracion"]-1;
		$talleres = $talleres. $hfin.':50';
		$talleres = $talleres. '</td><td bgcolor='.$bgcolor.'>'.$fila["nombre_lug"];
		$talleres = $talleres. '</td><td bgcolor='.$bgcolor.'>'.$fila["reg_time"];
		$talleres = $talleres. '</td></tr>';
		
	}
	$talleres = $talleres.'</table>';

$talleres = $talleres.'</div>';
//imprimePie();

$pdf = new DOMPDF();
$pdf->load_html($html.$talleres);
$pdf->render();
$pdf->stream("hojaregistro.pdf");
?>
