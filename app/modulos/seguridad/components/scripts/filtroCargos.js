$(filtroCargos());

function filtroCargos(consulta){
    $.ajax({
        url: '../controllers/consultas/filtroCargosCredenciales.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#datosCargos").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}  


$(document).on('keyup','#busqueda', function(){
	var valor = $(this).val();
	if (valor != "") {
		filtroCargos(valor);
	}else{
		filtroCargos();
	}
});