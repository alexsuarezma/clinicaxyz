function buscarCiudades(consulta){
    $.ajax({
        url: '../controllers/consultas/ciudades.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#print-ciudades").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}   

$(document).on('change', '#provincia', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarCiudades(valor);
        }
});
