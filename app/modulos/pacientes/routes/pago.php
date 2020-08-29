<?php
// require '../../../database.php';
require '../components/LayoutPublic.php';
session_start();
// require '../seguridad/controllers/functions/credenciales.php';
if(!$_POST){
    header('Location: ../home.php');
}

?>


<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pacientes | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../recursoshumanos/assets/styles/component/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php
printLayout ('home.php', '../../../index.php', '../../citasmedicas/', 'diagnostico.php', '#','../seguridad/controllers/logout.php','../seguridad/routes/perfil.php','home.php',1);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>
      <div class="container mt-5">
        <section class="shoping-cart spad">
            <div class="container mb-5">
                <span class="badge badge-success" style="font-size:16px;">La ubicación de envio se ha guardado correctamente.</span>
                <h2 class="mb-3">Pagar</h2>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" checked>
                    <label class="custom-control-label" for="customRadio1">Nueva Tarjeta de pago</label>
                </div>
            </div>
            <div class="container d-flex justify-content-around">
                <div class="shadow-sm p-3 mb-5 bg-white rounded" style="width:50%">
                    <form id="card-form">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="nombreTarjeta">Nombre en la tarjeta</label>
                                <input data-conekta="card[name]" value="" type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="numeroTarjeta">Numero de tarjeta</label>
                                <input value="4242424242424242" name="card" id="card" data-conekta="card[number]" type="text" class="form-control" maxlength="16">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombreTarjeta">CVC</label>
                                <input data-conekta="card[cvc]" value="399" type="text" class="form-control" id="cvc" onkeypress="return soloNumeros(event)" maxlength="3" minlength="3" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Fecha de expiración (MM/AA)</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <input value="11" data-conekta="card[exp_month]" type="text" class="form-control" id="month" onchange="soloMeses(this);" onkeypress="return soloNumeros(event)" maxlength="2" required>
                            </div>
                            <div class="form-group col-md-2">
                                <input value="20" data-conekta="card[exp_year]" type="text" class="form-control" id="year" onkeypress="return soloNumeros(event)" maxlength="2" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <!-- <label><span>Email</span></label> -->
                            <input class="form-control" type="hidden" name="email" id="email" maxlength="200" value="clinicavitalia@gmail.com">                        
                            <!-- <label>Concepto</label> -->
                            <input class="form-control" type="hidden" name="descripcion" id="descripcion" maxlength="100" value="cita clinica vitalia">                        
                            <!-- <label>Monto</label> -->
                            <input class="form-control" type="hidden" name="total" id="total" value="15.00">                        
                            <input type="hidden" name="id_pa" value="<?php echo $_POST['id_paciente']; ?>" id="id_pa">
                            <input type="hidden" name="id_doc" value="<?php echo $_POST['discos']; ?>" id="id_doc">
                            <input type="hidden" name="hora" value="<?php echo $_POST['discos_h']; ?>" id="hora">
                            <input type="hidden" name="fecha" value="<?php echo $_POST['bandas_f']; ?>" id="fecha">
                            <input type="hidden" name="especialidad" value="<?php echo $_POST['bandas']; ?>" id="especialidad">

                        </div>
                        <button id="pago" type="submit" style="display:none;" class="btn btn-primary">Pagar</button>
                        <input type="hidden" name="conektaTokenId" id="conektaTokenId" value="">
                    </form>      
                </div>
                <div class="shadow-lg p-4 mb-5 bg-white rounded" style="width:40%; height: 340px;">
                    <h3 class="font-weight-bolder mb-3">Resumen</h3>
                    <div class="d-flex justify-content-between" style="width:100%;">
                        <span class="">Precio Subtotal:</span>
                        <span class="mr-2">$ 13.20</span>
                    </div>
                    <hr class="mb-2">
                    <div class="d-flex justify-content-between mb-4" style="width:100%;">
                        <span class="">Total:</span>
                        <span class="mr-2">$ 15.00 </span>
                    </div>
                    <span style="margin-top:20px; font-size:11px;">Clinica Vitalia está obligado por ley a recaudar los impuestos sobre las transacciones de las compras realizadas en determinadas jurisdicciones fiscales.
                    <br>  Al completar la compra, aceptas estas <a href=""> Condiciones de uso.</a></span>
                    <div class="d-flex justify-content-center mt-4" style="width:100%">
                        <button type="hidden" onclick="enviarPago();" class="btn btn-danger" style="width:100%">Realizar pago</button>
                    </div>
                </div>        
            </div>
        </section>
      </div>
    </main>
  </div>
</div>

<div class='modal fade' name='modal-success' id='modal-success' data-backdrop='static' data-keyboard='false' tabindex='-1' role='dialog' aria-labelledby='staticBackdropLabe' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='staticBackdropLabel'>MENSAJE DE REGISTRO</h5>
                
            </div>
            <div class='modal-body mb-5'>
                <div class="container d-flex flex-column" style="width:100%;">
                    <div id="icon-message" class="container d-flex justify-content-center align-items-center mb-5 mt-4" style="width:100%;">
                        <!-- ICONO -->
                    </div>
                    <div class="container d-flex justify-content-center align-items-center" style="width:100%;">                            
                        <div id="message">
                            <!-- MESSAGE -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../../recursoshumanos/components/scripts/dashboard.js"></script>   
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script src="../../recursoshumanos/components/"></script>
<script src="../../recursoshumanos/controllers/validations/validations.js"></script>
<script src="../components/scripts/conekta.js"></script>  
<script>
    function enviarPago(){
        $("#pago").trigger("click");
    }
    function soloMeses(input){
        
        if(input.value > 0 && input.value <= 11){
        input.className = "form-control is-valid"
        }else{
        input.className = input.className+" is-invalid"
        input.value = "";
        input.focus();
        }
    }
    function soloNumeros(e){
    key=e.keyCode||e.which;
    teclado=String.fromCharCode(key);
    numero="0123456789";
    especiales="8-37-38-46";
    teclado_especial=false;
        for(var i in especiales){
        if(key==especiales[i]){
            teclado_especial=true;
        }
        }
        if (numero.indexOf(teclado)==-1 && !teclado_especial) {
        return false;
        }
    } 
</script>   
</body>
</html>








