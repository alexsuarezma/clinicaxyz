$(filtroUsuarios());

function filtroUsuarios(consulta){
    $.ajax({
        url: '../controllers/consultas/filtroUsuarios.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#datosUsuarios").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}  


$(document).on('keyup','#busqueda', function(){
	var valor = $(this).val();
	if (valor != "") {
		filtroUsuarios(valor);
	}else{
		filtroUsuarios();
	}
});