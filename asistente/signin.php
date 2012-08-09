<?php
include_once "../includes/lib.php";
include_once "../includes/conf.inc.php";

$link=conectaBD();
$errmsg = "";

if (empty($_POST['submit'])){   //Inicializa variables
    $_POST['S_login'] = '';
}

// para poder autorizar la insercion del registro

if (isset ($_POST['submit']) && ($_POST['submit'] == "Iniciar")) {
    if (!preg_match("/.+\@.+\..+/", $_POST['S_login']) || empty($_POST['S_passwd'])) {
        $errmsg .= '<div class="formcontainer"><p class="yacomas_error">Usuario y/o password no validos.
            Por favor trate de nuevo.</p></div>';
    } else {
        $lowlogin = strtolower($_POST['S_login']);
        $userQuery = 'SELECT id,mail,passwd FROM asistente WHERE mail="'.$lowlogin.'"';
        $userRecords = mysql_query($userQuery) or err("No se pudo checar el login".mysql_errno($userRecords));
        $rnum=mysql_num_rows($userRecords);
        
        if ($rnum == 0) {
            $errmsg = '<div class="formcontainer"><p class="yacomas_error">No existe ese usuario. 
                Trate de nuevo.</p></div>';
        } else {
            $p = mysql_fetch_array($userRecords);
            //Checar el password
            if ($p['passwd'] != substr(md5($_POST['S_passwd']),0,32)) {
                $errmsg =  '<div class="formcontainer"><p class="yacomas_error">Usuario y/o password incorrectos. 
                    Por favor intente de nuevo o <a href="reset.php">presiona aqui para resetear tu password</a>.</p></div>';
            } else {
                # begin session
                session_start();
                $_SESSION['YACOMASVARS']['asilogin'] = $lowlogin;
                $_SESSION['YACOMASVARS']['asiid'] = $p['id'];
                $_SESSION['YACOMASVARS']['asilast'] = time();
                # re-route user
                header('Location: menuasistente.php');
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
//imprimeCajaTop("50","Inicio de Sesion Asistente");
?> 
<h1 class="elementocentrado">Inicia tu sesión:</h1>

    <div class="formcontainer">
<?php
if (!empty($errmsg)) {
    print $errmsg;
} elseif (isset($_GET['e']) && ($_GET['e'] == "exp")) {
    print '<span class="errorfield">Su session ha caducado o no inicio session correctamente. 
        Por favor trate de nuevo.</span><p>';
}
?>
    </div>
<div class="formaregistro" style="padding: 40px 0">
    <form method="POST" action="<?php print $_SERVER['PHP_SELF'];?>">
    
    
    <div class="formcontainer">
        <label>Correo electrónico: </label>
        <input TYPE="text" name="S_login" size="15" value="<?php echo $_POST['S_login'] ?>">
    </div>
    <div class="formcontainer">
        <label>Contrase&ntilde;a: </label>
        <input type="password" name="S_passwd" size="15" value="">
    </div>    
    

    <br>
    <div class="elementocentrado">
        <div class="formcontainer">
            <input type="submit" name="submit" value="Iniciar">&nbsp;&nbsp;
            <input type="button" value="Cancelar" onClick=location.href="<?php echo $conference_link; ?>">
        </div>
    <br>
    </form>
    </br>
    <p class="yacomas_error">Las Cookies deben ser habilitadas pasado este punto.</p>    
    <span class="note">Su sesi&oacute;n caducara despu&eacute;s de 1 hora de inactividad</span>
    </div>
</div>
<?php
//imprimeCajaBottom(); 
//print '</div>';
imprimePie();
?>