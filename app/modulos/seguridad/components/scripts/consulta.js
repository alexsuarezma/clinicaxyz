function buscarScopes(consulta){
    $.ajax({
        url: '../controllers/consultas/scopes.php' ,
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

function buscarCredenciales(consulta){
    $.ajax({
        url: '../controllers/consultas/credenciales.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#credenciales").html(respuesta);
        $("#credencialesUsuario").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}   

function buscarCargos(consulta){
    $.ajax({
        url: '../controllers/consultas/cargo.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#inputCargo").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}   


function buscarCredencialesUsuario(consulta){
    $.ajax({
        url: '../controllers/consultas/credenciales.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#credencialesUsuario").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
}   

$(document).on('change', '#scope', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarScopes(valor);
        }
});

$(document).on('change', '#credencial', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarCredenciales(valor);
        }
});

$(document).on('change', '#credencialUsuario', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarCredencialesUsuario(valor);
        }
});

$(document).on('change', '#credenciales', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarCargos(valor);
        }
});
