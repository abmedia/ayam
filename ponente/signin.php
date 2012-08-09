<?php
include_once "../includes/lib.php";
include_once "../includes/conf.inc.php";
$link=conectaBD();

$errmsg = "";
if (empty($_POST['submit'])) {
	//Inicializa variables
	$_POST['S_login']='';	
}

// para poder autorizar la insercion del registro
if (isset ($_POST['submit']) && ($_POST['submit'] == "Iniciar")) {
    if (!preg_match("/^\w{4,15}$/",$_POST['S_login']) || empty($_POST['S_passwd'])) {
        $errmsg .= "<li>Usuario y/o password no validos. Por favor trate de nuevo";
    } else {
        $lowlogin = strtolower($_POST['S_login']);
        $userQuery = 'SELECT id,login,passwd FROM ponente WHERE login="'.$lowlogin.'"';
        $userRecords = mysql_query($userQuery) or err("No se pudo checar el login".mysql_errno($userRecords));

        $rnum=mysql_num_rows($userRecords);
        if ($rnum == 0) { 
            $errmsg = '<span class="error">No existe ese usuario.  Trate de nuevo.';
        }
        else {
            $p = mysql_fetch_array($userRecords);
            //Checar el password
            if ($p['passwd'] != substr(md5($_POST['S_passwd']),0,32)) {
                $errmsg =  ' <span class="err">Usuario y/o password incorrectos. 
                    Por favor intente de nuevo o <a href="reset.php"><br>Presiona aqui para resetear tu password</a>.</span>
                    <p><br>';
            } else {
                # begin session
                session_start();
                $_SESSION['YACOMASVARS']['ponlogin'] = $lowlogin;
                $_SESSION['YACOMASVARS']['ponid'] = $p['id'];
                $_SESSION['YACOMASVARS']['ponlast'] = time();
                # re-route user
                header('Location: menuponente.php');
                exit;
            }
        }
    }
}

// Aqui imprimimos la forma
// Solo deja de imprimirse cuando todos los valores han sido introducidos correctamente
// de lo contrario la imprimira para poder introducir los datos si es que todavia no hemos introducido nada
// o para corregir datos que ya hayamos tratado de introducir

imprimeEncabezado();
imprimeCajaTop("50","Inicio de Sesion Ponente");


if (!empty($errmsg)) {
    print $errmsg;
} elseif (isset($_GET['e']) && ($_GET['e'] == "exp")) {
    print '<span class="err">Su session ha caducado o no inicio session correctamente.  Por favor trate de nuevo.</span><p>'; 
}
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF'] ?>">
    <p class="yacomas_error">Las Cookies deben ser habilitadas pasado este punto.</p>
    <div class="formcontainer">
        <label>Nombre de Usuario: </label>
        <input TYPE="text" name="S_login" size="15" value="<?php print $_POST['S_login']; ?>">
    </div>

    <div class="formcontainer">
        <label>Contrase&ntilde;a: </label>
        <input type="password" name="S_passwd" size="15" value="">
    </div>

    <div class="elementocentrado">
        <input type="submit" name="submit" value="Iniciar">
        <input type="button" value="Cancelar" onClick=location.href="<?php print "../" ?>">
    </div>
</form>
		<span class="note">Su sessi&oacute;n caducara despues de 1 hora de inactividad</span>

<?php
imprimeCajaBottom(); 
imprimePie();
?>
