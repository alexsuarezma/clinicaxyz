$(document).ready(function(){
    $("#section").load("information.php");
    $('#informacion').click(function(){
        $("#section").load("information.php");
        document.getElementById("informacion").className = document.getElementById("informacion").className+" active";
        document.getElementById("horario").className = document.getElementById("horario").className.replace(" active", "");
        document.getElementById("actividades").className = document.getElementById("actividades").className.replace(" active", "");
        document.getElementById("contrato").className = document.getElementById("contrato").className.replace(" active", "");
        document.getElementById("update").className = document.getElementById("update").className.replace(" active", "");
    });
    $('#horario').click(function(){
        $("#section").load("asistencias.php");
        document.getElementById("horario").className = document.getElementById("horario").className+" active";
        document.getElementById("informacion").className = document.getElementById("informacion").className.replace(" active", "");
        document.getElementById("actividades").className = document.getElementById("actividades").className.replace(" active", "");
        document.getElementById("contrato").className = document.getElementById("contrato").className.replace(" active", "");
        document.getElementById("update").className = document.getElementById("update").className.replace(" active", "");
    });
    $('#actividades').click(function(){
        $("#section").load("actividades.html");
        document.getElementById("actividades").className = document.getElementById("actividades").className+" active";
        document.getElementById("horario").className = document.getElementById("horario").className.replace(" active", "");
        document.getElementById("informacion").className = document.getElementById("informacion").className.replace(" active", "");
        document.getElementById("contrato").className = document.getElementById("contrato").className.replace(" active", "");
        document.getElementById("update").className = document.getElementById("update").className.replace(" active", "");
    });
    $('#contrato').click(function(){
        $("#section").load("generarContrato.php");
        document.getElementById("contrato").className = document.getElementById("contrato").className+" active";
        document.getElementById("horario").className = document.getElementById("horario").className.replace(" active", "");
        document.getElementById("informacion").className = document.getElementById("informacion").className.replace(" active", "");
        document.getElementById("actividades").className = document.getElementById("actividades").className.replace(" active", "");
        document.getElementById("update").className = document.getElementById("update").className.replace(" active", "");
    });
    $('#update').click(function(){
        $('#modal-update').modal('show');
        $('#btn-update').click(function(){
            $("#section").load("updateInformation.php");
            document.getElementById("update").className = document.getElementById("update").className+" active";
            document.getElementById("horario").className = document.getElementById("horario").className.replace(" active", "");
            document.getElementById("actividades").className = document.getElementById("actividades").className.replace(" active", "");
            document.getElementById("contrato").className = document.getElementById("contrato").className.replace(" active", "");
            document.getElementById("informacion").className = document.getElementById("informacion").className.replace(" active", "");  
        });
    });
    
    $('#delete').click(function(){
        $("#modal-delete").modal('show');
        $('#btn-delete').click(function(){
           location.href=`../controllers/lockScreen.php?id=${$('#ocultCedula').text()}`;
        });  
    });

});