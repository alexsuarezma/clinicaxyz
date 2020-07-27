function buscarProveedores(consulta){
    $.ajax({
        url: '../controllers/consultas/productHasProveedor.php' ,
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


function buscarProveedores_informacion(consulta){
    $.ajax({
        url: '../controllers/consultas/proveedores.php' ,
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


function buscarProdProve(consulta){
    $.ajax({
        url: '../controllers/consultas/buscarProdProve.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {
            consulta: consulta
        },
    })
    .done(function(respuesta){
        $("#productoOC").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    });
} 


function buscarHasPro(consulta){
    $.ajax({
        url: '../controllers/consultas/buscarHasPro.php' ,
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



$(document).on('change', '#proveedor', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarProveedores_informacion(valor);
        }
});


$(document).on('change', '#proveedorOC', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarProdProve(valor);
            buscarHasPro(0);
        }
});

$(document).on('change', '#producto', function() {
    // Does some stuff and logs the event to the console
        var valor = $(this).val();
        if (valor != "") {
            buscarHasPro(valor);
        }
});