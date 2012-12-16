<?php  
include_once "../includes/lib.php";
include_once "../includes/conf.inc.php";
beginSession('A');
$idasistente=$_SESSION['YACOMASVARS']['asiid'];
imprimeEncabezado();

print '<P class="yacomas_login">Login: '.$_SESSION['YACOMASVARS']['asilogin'].'&nbsp;<a class="precaucion" href=signout.php>Desconectarme</a></P>';
print '<div>';
$link=conectaBD();
?>
<div class="requerido" style=" padding: 20px 50px;">
    <h3>Los campos marcados con un asterisco son obligatorios</h3>
    <li>Trata de no olvidar tu correo electr&oacute;nico, sirve para que inicies sesi�n</li>
    <li>Para conservar la contrase&ntilde;a actual, deja vac&iacute;os  los campos.</li>
</div>
<hr><br><br>    
<?php

function imprime_valoresOk() {
	include "../includes/conf.inc.php";

    print '
     	<table width=100%>
		<tr>
		<td class="name">Nombre de Usuario: * </td>
		<td class="resultado">
		'.$_POST['S_login'].'
		</td>
		</tr>

		<tr>
		<td class="name">Nombre(s): * </td>
		<td class="resultado">
		'.stripslashes($_POST['S_nombrep']).'
		</td>
		</tr>

		<tr>
		<td class="name">Apellidos: * </td>
		<td class="resultado">
		'.stripslashes($_POST['S_apellidos']).'
		</td>
		</tr>

		<tr>
		<td class="name">Correo Electr&oacute;nico: *</td>
		<td class="resultado">
		'.$_POST['S_mail'].'
		</td>
		</tr>

		<tr>
		<td class="name">Sexo: * </td>
		<td class="resultado">';
		
		if ($_POST['C_sexo']=="M")
		    echo "Masculino";
		else
		    echo "Femenino";
		    
	print '
		</td>
		</tr>

		<tr>
		<td class="name">Organizaci&oacute;n: </td>
		<td class="resultado">
		'.stripslashes($_POST['S_org']).'
		</td>
		</tr>

		<tr>
		<td class="name">Estudios: * </td>
		<td class="resultado">';
		
		$query = 'SELECT * FROM estudios WHERE id="'.$_POST['I_id_estudios'].'"';
		$result=mysql_query($query);
	 	while($fila=mysql_fetch_array($result)) {
			printf ("%s",$fila["descr"]);
  		}
		mysql_free_result($result);

	print '	
		</td>
		</tr>
		
		<tr>
		<td class="name">Tipo de Asistente: *</td>
		<td class="resultado">';
		
		$query = 'SELECT * FROM tasistente WHERE id="'.$_POST['I_id_tasistente'].'"';
		$result=mysql_query($query);
	 	while($fila=mysql_fetch_array($result)) {
			printf ("%s",$fila["descr"]);
  		}
		mysql_free_result($result);
		
	print '
		</td>
		</tr>

		<tr>
		<td class="name">Ciudad: </td>
		<td class="resultado">
		'.$_POST['S_ciudad'].'
		</td>
		</tr>

		<tr>
		<td class="name">Estado: * </td>
		<td class="resultado">';
		
		$query= "select * from estado where id='".$_POST['I_id_estado']."'";
		$result=mysql_query($query);
 		while($fila=mysql_fetch_array($result)) {
			printf ("%s",$fila["descr"]);
  		}
		mysql_free_result($result);
	print '
		</td>
		</tr>

		<tr>
		<td class="name">Fecha de Nacimiento: </td>
		<td class="resultado">';
		printf ("%02d-%02d-%04d",$_POST['I_b_day'],$_POST['I_b_month'],$_POST['I_b_year']);
	print '	
		</td>
		</tr>

		</table>
		<br>
		<center>
		<input type="button" value="Volver al menu" onClick=location.href="'.$fslpath.$rootpath.'/asistente/menuasistente.php">
		</center>';

}
// Si la forma ya ha sido enviada checamos cada uno de los valores
// para poder autorizar la insercion del registro
if (isset ($_POST['submit']) && $_POST['submit'] == "Actualizar") {
# do some basic error checking
    $errmsg = "";
// Verificar si todos los campos obligatorios no estan vacios
//Aqu� va empty($_POST['S_login']) || 
    if (empty($_POST['S_nombrep']) || empty($_POST['S_apellidos']) || empty($_POST['C_sexo']) || 
            empty($_POST['I_id_estudios']) || empty($_POST['I_id_tasistente']) || empty($_POST['I_id_estado'])) {
        $errmsg .= "<li>Verifica que los datos obligatorios los hayas introducido correctamente </li>";
    }
    
    if (!preg_match("/.+\@.+\..+/",$_POST['S_mail'])) {
        $errmsg .= "<li>El correo electronico tecleado no es v&aacute;lido";
    }
    
    if (!empty($_POST['S_passwd'])) {
    // Verifica que el login sea de al menos 4 caracteres
        if (!preg_match("/^\w{4,15}$/",$_POST['S_login'])) {
            $errmsg .= "<li>El login que elijas debe tener entre 4 y 15 caracteres";
        }
    // Verifica que el password sea de al menos 6 caracteres
        if (!preg_match("/^.{6,15}$/",$_POST['S_passwd'])) {
            $errmsg .= "<li>El password debe tener entre 6 y 15 caracteres";
        }
    // Verifica que el password usado no sea igual al login introducido por seguridad
        if ($_POST['S_passwd'] == $_POST['S_login']) {
            $errmsg .= "<li>El password no debe ser igual a tu login";
        }
    // Verifica que los password esten escritos correctamente para verificar que
    // la persona introducjo correcamente el password que eligio.
        if ($_POST['S_passwd'] != $_POST['S_passwd2']) {
            $errmsg .= "<li>Los passwords no concuerdan";
        }
    }
// Si no hay errores verifica que el login no este ya dado de alta en la tabla

    if (empty($errmsg) && !empty($_POST['S_login'])) {
        $lowlogin = strtolower($_POST['S_login']);
        $userQuery = 'SELECT id FROM asistente WHERE login="'.$lowlogin.'"';
        $userRecords = mysql_query($userQuery) or err ("No se pudo checar el login del asistente".mysql_errno($userRecords));
        if (mysql_num_rows($userRecords) != 0) {
            $p = mysql_fetch_array($userRecords);
            if ($p['id'] != $idasistente) {
                $errmsg .= "<li>El usuario que elegiste ya ha sido tomado; por favor elige otro";
            }
        }
    }
    
    // Si hubo error(es) muestra los errores que se acumularon.
    if (!empty($errmsg)) {
        showError($errmsg);
        print '<p class="yacomas_error">Note que los campos de password han sido borrados<p>';
    } else {
        // Si todo esta bien vamos a darlo de alta
        // Todas las validaciones Ok, vamos a darlo de alta
        $f_nac=$_POST['I_b_year'].'-'.$_POST['I_b_month'].'-'.$_POST['I_b_day'];
        $login = "";
        if(empty($_POST['S_login'])){
            $login = "NULL";
        }else{
            $login = "'".$lowlogin."'";
        }

    // Funcion comentada para no agregar los datos de prueba, una vez que este en produccion hay que descomentarla

        if (!empty($_POST['S_passwd'])) {
            $query = "UPDATE asistente SET login=".$login.", 
            passwd="."'".md5(addslashes($_POST['S_passwd']))."',
            nombrep="."'".mysql_real_escape_string(addslashes($_POST['S_nombrep']))."',
            apellidos="."'".mysql_real_escape_string(addslashes($_POST['S_apellidos']))."',
            sexo="."'".$_POST['C_sexo']."',
            mail="."'".$_POST['S_mail']."',
            ciudad="."'".$_POST['S_ciudad']."',
            org="."'".addslashes($_POST['S_org'])."',
            fecha_nac="."'".$f_nac."',
            id_estudios="."'".$_POST['I_id_estudios']."',
            id_tasistente="."'".$_POST['I_id_tasistente']."',
            id_estado="."'".$_POST['I_id_estado']."'
            WHERE id="."'".$idasistente."'";
        } else {
            $query = "UPDATE asistente SET login=".$login.",
            nombrep="."'".mysql_real_escape_string(addslashes($_POST['S_nombrep']))."',
            apellidos="."'".mysql_real_escape_string(addslashes($_POST['S_apellidos']))."',
            sexo="."'".$_POST['C_sexo']."',
            mail="."'".$_POST['S_mail']."',
            ciudad="."'".$_POST['S_ciudad']."',
            org="."'".addslashes($_POST['S_org'])."',
            fecha_nac="."'".$f_nac."',
            id_estudios="."'".$_POST['I_id_estudios']."',
            id_tasistente="."'".$_POST['I_id_tasistente']."',
            id_estado="."'".$_POST['I_id_estado']."'
            WHERE id="."'".$idasistente."'";
        }
        // Para debugear
        // print $query;
        $result = mysql_query($query) or err("No se puede actualizar los datos".mysql_errno($result));
        print $_POST['S_nombrep'].' Has actualizado tus datos .
        <p>Si tienes preguntas o no sirve adecuadamente la p&aacute;gina, por favor contacta a 
        <a href="mailto:'.$adminmail.'">Administraci&oacute;n '.$conference_name.'</a><br><br>';

        imprime_valoresOk();
        imprimeCajaBottom();
        imprimePie(); 

        //  Necesitamos este exit para salirse ya de este programa y evitar que se imprima la forma porque 
        //  los datos ya fueron intruducidos y la transaccion se realizo con exito
        exit;
    }
} else {

    // Aqui imprimimos la forma
    // Solo deja de imprimirse cuando todos los valores han sido introducidos correctamente
    // de lo contrario la imprimira para poder introducir los datos si es que todavia no hemos introducido nada
    // o para corregir datos que ya hayamos tratado de introducir

    $userQuery = 
    'SELECT * FROM asistente WHERE id="'.$idasistente.'"';
    $userRecords = mysql_query($userQuery) or err("No se pudo checar el login".mysql_errno($userRecords));
    $p = mysql_fetch_array($userRecords);
    $_POST['S_login']=$p['login'];
    $_POST['S_nombrep']=$p['nombrep'];
    $_POST['S_apellidos']=$p['apellidos'];
    $_POST['S_mail']=$p['mail'];
    $_POST['C_sexo']=$p['sexo'];
    $_POST['S_org']=$p['org'];
    $_POST['I_id_estudios']=$p['id_estudios'];
    $_POST['I_id_tasistente']=$p['id_tasistente'];
    $_POST['S_ciudad']=$p['ciudad'];
    $_POST['I_id_estado']=$p['id_estado'];

    $fec_nac=$p['fecha_nac'];
    $year=substr($fec_nac,0,4);
    $month=substr($fec_nac,5,2);
    $day=substr($fec_nac,8,2);
    $_POST['I_b_year']=$year;
    $_POST['I_b_month']=$month;
    $_POST['I_b_day']=$day;
}

print'<FORM method="POST" action="'.$_SERVER['REQUEST_URI'].'">
    <div class="formaregistro">
        
        
        <div class="formcontainer">
        <label class="requerido">Correo Electr&oacute;nico:</label>
        <input type="text" name="S_mail" size="15" value="'.$_POST['S_mail'].'">
        </div>
        
        <div class="formcontainer">
        <label>Nombre de Usuario: * </label>
        <input TYPE="text" name="S_login" size="15" value="'.$_POST['S_login'].'">
        <label style=" width: 40px; float: right; font-size: 10px; padding: 0; color: red">4 a 15 caracteres</label>
        </div>

        <div class="formcontainer">
        <label class="requerido">Contrase&ntilde;a:</label>
        <input type="password" name="S_passwd" size="15" value="">
        <label style=" width: 40px; float: right; font-size: 10px; padding: 0; color: red">6 a 15 caracteres</label>
        </div>

        <div class="formcontainer">
        <label class="requerido">Confirmaci&oacute;n de Contrase&ntilde;a:</label>
        <input type="password" name="S_passwd2" size="15" value="">
        </div>

        <div class="formcontainer">
        <label class="requerido">Nombre(s):</label>
        <input type="text" name="S_nombrep" size="30" value="'.stripslashes($_POST['S_nombrep']).'">
        </div>

        <div class="formcontainer">
        <label class="requerido">Apellidos:</label>
        <input type="text" name="S_apellidos" size="30" value="'.stripslashes($_POST['S_apellidos']).'">
        </div>

        <div class="formcontainer">
        <label class="requerido">Sexo:</label>
        <select name="C_sexo">
            <option name="unset" value="" ';
if (empty($_POST['C_sexo']))
    echo "selected";
print '></option>
        <option value="M"';
if ($_POST['C_sexo']=="M")
    echo "selected";
print ' >Masculino</option>"
        <option value="F"';
if ($_POST['C_sexo']=="F")
    echo "selected";
print ' >Femenino</option>
        </select>
        </div>

        <div class="formcontainer">
        <label>Organizaci&oacute;n: </label>
        <input type="text" name="S_org" size="15" value="'.stripslashes($_POST['S_org']).'">
        </div>
    
        <div class="formcontainer">
        <label>Estudios:</label>
        <select name="I_id_estudios">';
//      <option name="unset" value="0"';
//		if (empty($_POST['I_id_estudios'])) 
//			echo " selected";
//	print '
//		></option>';

$result=mysql_query("select * from estudios order by id");
while($fila=mysql_fetch_array($result)) {
    print '<option value="'.$fila['id'].'" ';
    if ($_POST['I_id_estudios']==$fila['id'])
        echo 'selected';
    print '>'.$fila["descr"].'</option>';
}
mysql_free_result($result);

print '</select>
        </div>
    
        <div class="formcontainer">
        <label class="requerido">Tipo de Asistente:</label>
        <select name="I_id_tasistente">';

//    <option name="unset" value="0"';
//if (empty($_POST['I_id_tasistente'])) 
//        echo " selected";
//print '></option>';

$result=mysql_query("select * from tasistente order by id");
while($fila=mysql_fetch_array($result)) {
    print '<option value='.$fila["id"];
    if ($_POST['I_id_tasistente']==$fila["id"])
        echo " selected";
    print '>'.$fila["descr"].'</option>';
}
mysql_free_result($result);

print ' </select>
        </div>

        <div class="formcontainer">
        <label>Ciudad: </label>
        <input type="text" name="S_ciudad" size="10" value="'.stripslashes($_POST['S_ciudad']).'">
        </div>

        <div class="formcontainer">
        <label class="requerido">Estado:</label>
        <select name="I_id_estado">';

//        <option name="unset" value="0"';
//if (empty($_POST['I_id_estado'])) 
//        echo " selected";
//print '
//></option>';

$result=mysql_query("select * from estado order by id");
while($fila=mysql_fetch_array($result)) {
    print '<option value='.$fila["id"];
    if ($_POST['I_id_estado']==$fila["id"])
        echo " selected";
    print '>'.$fila["descr"].'</option>';
}
mysql_free_result($result);

print '
        </select>
        </div>

        <div class="formcontainer">
        <label>Fecha de Nacimiento:</label>
        <select name="I_b_day" style="width: 66px">
        <option name="unset" value="0"';
if (empty($_POST['I_b_day'])) 
        echo " selected";
print '
        >D�a</option>';

// echo $day;
// echo $_POST['I_b_day'];

for ($Idia=1;$Idia<=31;$Idia++){
    printf ("<option value=%02d",$Idia);
    if ($_POST['I_b_day']==$Idia)
        echo " selected";
    printf (">%02d </option>",$Idia);
}

print ' </select>    
        <select name="I_b_month" style="width: 66px">
        <option name="unset" value="0"';
if (empty($_POST['I_b_month']))
    echo "   selected";
print '>Mes</option>';
for ($Imes=1;$Imes<=12;$Imes++){
    printf ("<option value=%02d",$Imes);
    if ($_POST['I_b_month']==$Imes)
        echo " selected";
    printf (">%02d </option>",$Imes);
}
print ' </select>
        <select name="I_b_year" style="width: 66px">
        <option name="unset" value="0"';
if (empty($_POST['I_b_year']))
    echo " selected";
print '
        >A&ntilde;o</option>';
for ($Ianio=1999;$Ianio>=1950;$Ianio--){
    print '<option value='.$Ianio;
    if ($_POST['I_b_year']==$Ianio)
        echo " selected";
    print '>'.$Ianio.'</option>';
}
print ' </select>
        </div>
    </div>

<br>

<center>
<div class="formcontainer">
    <input type="submit" name="submit" value="Actualizar">&nbsp;&nbsp;
    <input type="button" value="Volver al Menu" onClick=location.href="'.$conference_link.'/asistente/menuasistente.php">
</div>
</center>

</form>';

//imprimeCajaBottom(); 
print '</div>';
imprimePie(); 
?>