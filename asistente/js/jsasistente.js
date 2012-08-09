function verificarEmail(){
    mail = document.getElementById('email').value;
    var filtro = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(mail.lenght == 0 ){
        setErrorClass('email', 'Debes ingresar un correo electrónico');
    }
    if (!filtro.test(mail)) {
        setErrorClass('email', 'El email que ingresante, es inválido');
    } else {
        buscarEmail();
    }
}

function buscarEmail(){
    $.ajax({
        type: 'POST',
        data: 'email=' + $('#email').val(),
        url: 'actions/comprobaremail.php',
        success: function(result){
            div = document.getElementById('mensajes');
            if (result >= 1) {
                errorClass('email')
                imprimirMensaje("El email está ocupado");
            }
            else{
                imprimirMensaje("El email está disponible");
                validateClass('email');
            }
        }
    });
}

function verificarNickname(){
    var nick = document.getElementById('login').value;
    if(nick == ''){
        document.getElementById('login').className = "";
    } else if (tieneEspacios(nick)){
        setErrorClass('login', 'Tu nick no debe contener espacios');
    } else  if (nick.length < 4) {
        setErrorClass('login', "El nick debe tener al menos 4 catacteres "+nick.length)
    } else {
        $.ajax({
            type: 'GET',
            data: 'login=' + $('#login').val(),
            url: 'actions/comprobarnick.php',
            success: function(result){
                if (result == 0) {
                    setValidateClass('login', "El nick está disponible");
                } else if (result > 0)
                    setErrorClass('login', " El nickname está ocupado ");
                else{
                    setErrorClass('login',"La palabra que introduciste no es válida");
                }
            }
        });
    }
}

function tieneEspacios(texto){
    contiene = false;
    for (i = 0; i < texto.length; i++) {
        if (texto.charAt(i) == " ") {
            contiene = true;
        }
    }
    return contiene;
}

function verificarPass(){
    passuno = document.getElementById('password').value;
    passdos = document.getElementById('confirmarpass').value;
    if (passuno == ""){
        errorClass('password');
        errorClass('confirmarpass');
        imprimirMensaje("Las contraseñas están vacías");
    }
    if (passuno == passdos && passuno.length >= 6 && passdos.length >= 6 ) {
        validateClass('password');
        validateClass('confirmarpass');
        imprimirMensaje('Los pass son iguales');
    }else if(passuno.length < 6 && passdos.length < 6 ){
        errorClass('password');
        errorClass('confirmarpass');
        imprimirMensaje("Las contraseñas no tienen el tamaño mínimo");
    } else {
        errorClass('password');
        errorClass('confirmarpass');
        imprimirMensaje("Las contraseñas no coinciden");
    }
}

function verificarCamposVacios(){
    verificarEmail();
    verificarPass();
    verificarCampoVacio("nombre");
    verificarCampoVacio("apellidos")
}

function verificarCampoVacio(id){
    if (document.getElementById(id).value == "")
        errorClass(id);
    else
        validateClass(id);
}

function verificarCampoVacio(id, tamanio){
    if (document.getElementById(id).value == "")
        errorClass(id);
    else if(document.getElementById(id).value.length < tamanio)
        setErrorClass(id, 'El tamaño mínimo de este campo es de '+tamanio);
    else
        validateClass(id);
}

function validarDatos(){
    verificarCamposVacios();
    if (contarErrorClass()) {
        imprimirMensaje("Hay algunos errores en tus datos, no te podrás inscribir hasta verificarlos");
    }else{
        enviarDatos();
    }
}

function contarErrorClass(){
    formulario = document.formaregistro;
    error = false;
    for (i = 0; i < formulario.elements.length; i++)
        if (formulario.elements[i].className == "errorfield"){
            error = true;
    }
    return error;
}

function enviarDatos(){
    datos = 'login='+$('#login').val() +'& nombre='+$('#nombre').val() + '& apellidos=' + $('#apellidos').val()
        + '& password=' + $('#password').val() + '& email=' + $('#email').val()+ '& sexo=' + $('#sexo').val().charAt(0)
        + '& fnacimiento=' + $('#fnacimiento').val() + '& estado=' + (document.getElementById('estado').selectedIndex + 1) 
        + '& ciudad=' + $('#ciudad').val() + '& tipoasistente=' + (document.getElementById('tipoasistente').selectedIndex + 1)
        + '& nivelestudio=' + (document.getElementById('nivelestudio').selectedIndex + 1)
        + '& organizacion=' + $('#organizacion').val();
    $.ajax({
            type: 'POST',
            data: datos,
            url: 'actions/nuevoasistente.php',
            success: function(result){
                div = document.getElementById('contenido');
                if (result) {
                    imprimirMensajeRegistro(result);
                }
                
            }
    });
}

function buscarChar(caracter, expresion){
    encontrado = false;
    for (i = 0; i < expresion.length; i++) {
        if (caracter == expresion.charAt(i)) {
            encontrado = true;
            alert('Encont');
        }
    }
    return encontrado;
}

function setErrorClass(elemento, mensaje){
    errorClass(elemento);
    imprimirMensaje(mensaje);
}

function errorClass(elemento){
    document.getElementById(elemento).className = "errorfield";
}

function setValidateClass(elemento, mensaje){
    validateClass(elemento);
    imprimirMensaje(mensaje);
}

function validateClass(elemento){
    document.getElementById(elemento).className = "validatefield";
}

function imprimirMensaje(mensaje){
    div = document.getElementById('mensajes');
    div.innerHTML = mensaje;
}

function imprimirMensajeRegistro(mensaje){
    div = document.getElementById('contenido');
    div.innerHTML = mensaje;
}