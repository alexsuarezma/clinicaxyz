function buscar_cargos(consulta){
    $.ajax({
        url: '../controllers/consultas.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#objeto").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}   

function buscar_horarios(horario){
    $.ajax({
        url: '../controllers/consultas.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            horario: horario
        },
    })
    .done(function(respuesta){
        $("#jornadaHora").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}  

function buscar_sueldos(cargo){
    $.ajax({
        url: '../controllers/consultas.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            cargo: cargo
        },
    })
    .done(function(respuesta){
        $("#sueldo").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}   


$(document).on('change', '#area', function() {
// Does some stuff and logs the event to the console
    var valor = $(this).val();
    if (valor != "") {
        buscar_cargos(valor);
        buscar_sueldos(0);
        buscar_horarios(0);
    }
});

$(document).on('change', '#horario', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscar_horarios(valor);
        }
});

$(document).on('change', '#cargo', function() {
// Does some stuff and logs the event to the console
    var valor = $(this).val();
    if (valor != "") {
        buscar_sueldos(valor);
        isMedic(this,'row-especialidad');
    }
});