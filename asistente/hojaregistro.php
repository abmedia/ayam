<?php
include '../includes/lib.php';
imprimeEncabezado();
getJquery();
?>
<div class="requerido" style="width: 600px; margin: 0 auto">
    <h3 class="elementocentrado">Los campos marcados con una bandera son obligatorios.</h3>
</div>
<hr><div id="mensajes"></div><br><br>
	<form name="nuevoasistente">
    <div id="form-box">
        <script type="text/javascript" src="js/jsasistente.js"></script>
		<label class="requerido">Correo electrónico: </label>
		<input type="text" id="email" onKeyUp="verificarEmail()">
			
		<label>Nickname: </label>
		<input type="text" id="login" onKeyUp="verificarNickname()">
			
		<label class="requerido">Contraseña: </label>
		<input type="password" id="password">

		<label class="requerido">Verificar contraseña: </label>
		<input type="password" id="confirmarpass" onKeyUp="verificarPass()">
			
		<label class="requerido">Nombre(s): </label>
		<input type="text" id="nombre" onChange="verificarCampoVacio('nombre')">
			
			
		<label class="requerido">Apellido(s): </label>
		<input type="text" id="apellidos" onChange="verificarCampoVacio('apellidos')">
			
		<label>Fecha de Nacimiento: </label>
		<input type="text" id="fnacimiento" READONLY>
			
		<label>Sexo: </label>
		<select id="sexo"><?php getListaSexos() ?></select>
			
		<label class="requerido">Estado: </label>
		<select id="estado"><?php getListaEstados(); ?></select>
			
		<label>Ciudad: </label>
		<input type="text" id="ciudad">
			
		<label class="requerido">Tipo de Asistente: </label>
		<select id="tipoasistente"><?php getListaTiposAsistentes() ?></select>
            
        <label>Nivel de Estudios: </label>
        <select id="nivelestudio"><?php getListaNivelesEstudio() ?></select>
		
        <label>Organización: </label>
        <input type="text" id="organizacion">
	</div>
	<div class="elementocentrado">
		<input type="button" onClick="validarDatos()" value="Registrarse">
		<input type="button" onclick="document.location = '<?php echo $conference_link; ?>'" value="Cancelar">
	</div>
	<?php jqueryUiPrint(); ?>
	</form>
<?php
imprimePie();
?>