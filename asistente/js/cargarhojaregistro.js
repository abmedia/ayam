function cargarHojaRegistro(){
    var html = document.getElementById('contenido').innerHTML;
    window.open('actions/crearhojaregistro.php?html='+html, 'Hoja', '');
/*
    $.ajax({
        type: 'POST',
        data: 'html=' + html,
        url: 'actions/crearhojaregistro.php',
        success: function(result){
            pdf = result;
            var output = window.open(pdf);
            output.focus();
        }
    });
*/
}


