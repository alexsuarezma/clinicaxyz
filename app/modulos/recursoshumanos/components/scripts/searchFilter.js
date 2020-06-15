$(personal($('#personal').text()));

function buscar_datos(consulta, personal){
	$.ajax({
		url: '../controllers/searchFilter.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {
			consulta: consulta,
			personal: personal,
		},
	})
	.done(function(respuesta){
		$("#datos").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}

function personal(personal){
	$.ajax({
		url: '../controllers/searchFilter.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {
			personal: personal
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
		buscar_datos(valor,personal);
	}else{
		personal($('#personal').text());
	}
});