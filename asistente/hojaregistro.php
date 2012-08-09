<?php
include '../includes/lib.php';
imprimeEncabezado();
getJquery();
?>
<div class="requerido" style="width: 600px; margin: 0 auto">
    <h3 class="elementocentrado">Los campos marcados con una bandera son obligatorios.</h3>
</div>
<hr><div id="mensajes"></div><br><br>
    <div class="formaregistro" >
        <script type="text/javascript" src="js/jsasistente.js"></script>
        <form name="formaregistro">
            <div class="formcontainer">
                <label class="requerido">Correo electrónico: </label>
                <input type="text" id="email" onKeyUp="verificarEmail()">
            </div>
            <div class="formcontainer">
                <label>Nickname: </label>
                <input type="text" id="login" onKeyUp="verificarNickname()">
                <label class="campo-info">4 a 15 caracteres</label>
            </div>
            <div class="formcontainer">
                <label class="requerido">Contraseña: </label>
                <input type="password" id="password">
                <label class="campo-info">6 a 15 caracteres</label>
            </div>
            <div class="formcontainer">
                <label class="requerido">Verificar contraseña: </label>
                <input type="password" id="confirmarpass" onKeyUp="verificarPass()">
            </div>
            <div class="formcontainer">
                <label class="requerido">Nombre(s): </label>
                <input type="text" id="nombre" onChange="verificarCampoVacio('nombre')">
            </div>
            <div class="formcontainer">
                <label class="requerido">Apellido(s): </label>
                <input type="text" id="apellidos" onChange="verificarCampoVacio('apellidos')">
            </div>
            <div class="formcontainer">
                <label>Fecha de Nacimiento: </label>
                <input type="text" id="fnacimiento" READONLY>
            </div>
            <div class="formcontainer">
                <label>Sexo: </label>
                <select id="sexo"><?php getListaSexos() ?></select>
            </div>
            <div class="formcontainer">
                <label class="requerido">Estado: </label>
                <select id="estado"><?php getListaEstados(); ?></select>
            </div>
            <div class="formcontainer">
                <label>Ciudad: </label>
                <input type="text" id="ciudad">
            </div>
            <div class="formcontainer">
                <label class="requerido">Tipo de Asistente: </label>
                <select id="tipoasistente"><?php getListaTiposAsistentes() ?></select>
            </div>
            <div class="formcontainer">
                <label>Nivel de Estudios: </label>
                <select id="nivelestudio"><?php getListaNivelesEstudio() ?></select>
            </div>
            <div class="formcontainer">
                <label>Organización: </label>
                <input type="text" id="organizacion">
            </div>
        </form>
            <div class="elementocentrado">
                <input type="button" onClick="validarDatos()" value="Registrarse">
                <input type="button" onclick="document.location = '<?php echo $conference_link; ?>'" value="Cancelar Registro">
            </div>
        <!--</form>-->
        
        <?php jqueryUiPrint(); ?>
    </div>

<?php
imprimePie();
?>
