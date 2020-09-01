function buscar_facturas(consulta){
	$.ajax({
		url: '../controllers/filtroFacturas.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {
			consulta: consulta
		},
	})
	.done(function(respuesta){
		$("#datos").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}

$(document).on('keyup','#busqueda', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_facturas(valor);
	}else{
		buscar_facturas();
	}
});