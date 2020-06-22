<?php
    if(isset($_POST['enviar'])){
        var_dump($_POST['numeroHijos']);
        
        for($i=1;$i<=$_POST['numeroHijos'];$i++){
            var_dump($_POST["nombreHijo$i"]);
            var_dump($_POST["apellidoHijo$i"]);
            var_dump($_POST["anosHijo$i"]);
            var_dump($_POST["mesesHijo$i"]);
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Input Dinamico</title>

    <head>
        <title>Agregar o eliminar dinámicamente los campos en PHP con JQuery</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    </head>
</head>
<body>
<div class="container">
    <br />
    <br />
    <h2 >Agregar o eliminar dinámicamente los campos en PHP con JQuery</h2><br><br>
    <div class="row col-md-10">
        <div class="form-group">
            <form action="prueba.php" method="POST" name="add_name" id="add_name">
                <div class=""id="dynamic_field">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="validationServer04">Nombres</label>
                            <input type="text" name="nombreHijo1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer14" autocomplete="off">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="validationServer04">Apellidos</label>
                            <input type="text" name="apellidoHijo1" class="form-control" onkeypress="return soloLetras(event)" id="validationServer15" autocomplete="off">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04">Años</label>
                            <input type="text" name="anosHijo1" class="form-control" onkeypress="return soloNumeros(event)" id="validationServer16" autocomplete="off">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="validationServer04">Meses</label>
                            <input type="text" name="mesesHijo1" class="form-control" onkeypress="return soloNumeros(event)" id="validationServer17" autocomplete="off">
                        </div>
                        <div class="col-md-1 "><i class="fa fa-plus-circle" name="add" id="add" aria-hidden="true" style="cursor:pointer;"></i></div>   
                        <div class="col-md-1"><i class="fa fa-minus-circle" name="remove" id="remove" aria-hidden="true" style="cursor:pointer;"></i></button></div>
                    </div>
                    <input  name="numeroHijos" style="display:none;" id="numeroHijos" value="<?php echo 1;?>">
                    <!-- <button name="enviar" id="enviar">enviar</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>

    $(document).ready(function(){
        var i = 1;

        $('#add').click(function () {
            i++;
            $('#dynamic_field').append(`<div class="form-row" id="row${i}">`+
                                            '<div class="col-md-3 mb-3">'+
                                                '<label for="validationServer04">Nombres</label>'+
                                                `<input type="text" name="nombreHijo${i}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer14" autocomplete="off">`+
                                            '</div>'+
                                            '<div class="col-md-3 mb-3">'+
                                                '<label for="validationServer04">Apellidos</label>'+
                                                `<input type="text" name="apellidoHijo${i}" class="form-control" onkeypress="return soloLetras(event)" id="validationServer15" autocomplete="off">`+
                                            '</div>'+
                                            '<div class="col-md-2 mb-3">'+
                                                '<label for="validationServer04">Años</label>'+
                                                `<input type="text" name="anosHijo${i}" class="form-control" onkeypress="return soloNumeros(event)" id="validationServer16" autocomplete="off">`+
                                            '</div>'+
                                            '<div class="col-md-2 mb-3">'+
                                                '<label for="validationServer04">Meses</label>'+
                                                `<input type="text" name="mesesHijo${i}" class="form-control" onkeypress="return soloNumeros(event)" id="validationServer17" autocomplete="off">`+
                                            '</div>'+
                                        '</div>');
            document.getElementById("numeroHijos").value = i;
        });

        $('#remove').click(function () {
            if(i == 1){

            }else{
                $('#row'+ i).remove();
                i--;
                document.getElementById("numeroHijos").value = i;
            }
        });      
    })
</script>


</body>
</html>