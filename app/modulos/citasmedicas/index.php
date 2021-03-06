<?php
error_reporting(E_ALL ^ E_NOTICE);
require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';
require '../pacientes/components/LayoutPublic.php';

verificarAcceso("../../../", "paciente");



 date_default_timezone_set('AMERICA/GUAYAQUIL');
    $variale= "";
    $vari="";
    $cedula="";

     $fecha_actual=date("Y-m-d");  
              include ('conexion.php');

              if (isset($_POST['enviar'])) {
                $cedula=$_POST['cedula'];
               $resultado_cedula=0;

                           
                  $consulta="select *  from pacientes  where idpacientes=".$cedula;
                  $resultado=mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
                  $variale=mysqli_num_rows($resultado);
                  if ($variale>0)
                  {
                                 $vari="<div class='alert alert-success' role='alert'>
                    La cédula que ingresó si consta como registrada!!
                  </div>";
         
                  } else {
                  
                           $vari="<div class='alert alert-danger' role='alert'>
                    La cédula que ingresó no se encuentra registrada. <a href='../pacientes/'  class='alert-link'>REGISTRARME!!</a>
                  </div>";
          
                  }


              } 


            
  if (isset($_POST['guardar'])) {
                $id_paciente=$_POST['id_paciente'];
                $cedula = $_POST['cedula'];
                $especialidad=$_POST['bandas'];
                $especialista=$_POST['discos'];
                $fecha=$_POST['bandas_f'];
                $hora=$_POST['discos_h'];
             


                $fecha_de_registro=Date("Y-m-d H-i-s");


              
               //   mysqli_query($conexion,$guardar_cita);
      
               echo ("<script LANGUAGE='JavaScript'>
               
               window.location.href='confirmar_pago.php? id_paciente=".$id_paciente." & cedula=".$cedula." & especialidad=".$especialidad." & especialista=".$especialista." & fecha=".$fecha." & hora=".$hora." ';
               </script>");

               
               
              }
              
              ?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pacientes | Cita Medica</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../recursoshumanos/assets/styles/component/dashboard.css" rel="stylesheet">
    <link href="form-validation.css" rel="stylesheet">
    <LINK REL=StyleSheet HREF="formulario.css" TYPE="text/css" MEDIA=screen>
    <link rel="icon" type="image/png" href="logo1.png" />
  <script type="text/javascript"> 
  function controltag(e) {
      tecla = (document.all) ? e.keyCode : e.which;
      if (tecla==8) return true;
      else if (tecla==0||tecla==9)  return true;
     // patron =/[0-9\s]/;// -> solo letras
      patron =/[0-9\s]/;// -> solo numeros
      te = String.fromCharCode(tecla);
      return patron.test(te);
    }

    function validar(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/[A-Za-z\s]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
    }
  </script>
  </head>
  <body>
<?php
printLayout ('../pacientes/home.php', '../../../index.php', 'index.php', '../pacientes/routes/diagnostico.php', '../pacientes/routes/facturas.php','../seguridad/controllers/logout.php','../seguridad/routes/perfil.php','../pacientes/home.php',2);
?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>

    <h2 class="mt-5" style="text-align:center;">Citas Médicas</h2>
    <div class="container">

<!-- comienzo del formulario-->
  <div class="row">
    <div class="col-md-8 order-md-1 mt-5">
      <h4 class="mb-3">Solicitar cita</h4>



      <form class="needs-validation" novalidate  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"  method="post">
        <div class="row">
         
          <div class="col-md-6 mb-3">

            <label for="firstName">
             Cédula (<?php include 'funcion_cedula.php'; $resultado_cedula=validarCI($cedula); ?> )
            </label>
       

            
            <input type="text"class="form-control"  id="cedula" name="cedula" maxlength="10" placeholder="Ingrese su cédula" value="<?php  echo $cedula ?>" required onkeypress="return controltag(event)" onchange="validar_cedula(event)"  > 
           
            <div class="invalid-feedback">
             El campo esta vacio
            </div>

           <?php   echo $vari;   ?>
 
          </div>
                   <div class="col-md-4 mb-1">
                               <br>
                     <button class="btn btn-primary btn-lg btn-block" name="enviar" id="enviar" type="submit" onclick="validar_cedula(event)">Consultar</button>


                    </div>

        </div>

      </form>
      <!-- <?php echo htmlspecialchars($_SERVER['PHP_SELF'])?> -->

      <form class="needs-validation" novalidate  action="../pacientes/routes/pago.php"  method="post"> 



<?php

// Conectando, seleccionando la base de datos


// Realizar una consulta MySQL

if ($variale>0) {


$query = 'SELECT * FROM pacientes where idpacientes='.$cedula.' ';

$result = mysqli_query($conexion,$query) or die('Consulta fallida: ' . mysqli_error($conexion));

while ($row = mysqli_fetch_array($result)){

  ?>
        <div class="form-group">
        <label for="formGroupExampleInput">Nombres y Apellidos</label>
        <input type="hidden" name="id_paciente" id="id_paciente" value="<?php echo $row['idpacientes']; ?>">
        <input type="text" class="form-control" id="nombre"  value="<?php echo $row['nombres']." ".$row['ape_paterno']." ".$row['ape_mat']; ?>" disabled="">
        </div>
  <?php
        
        /* */
        include 'con_db.php';
        $con = conDb();
if(!$con){
  die("<br/>Sin conexi&oacute;n.");
  echo "error";
}

/*obtenemos los datos del primer select*/
$sql = "select * from especialidades";
$query = mysqli_query($con, $sql);
$filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
mysqli_close($con);

// eñ id banda es especialidad y discos es especialista xD 

 ?>
    <div  class="row">
     <div class="col-md-6 mb-3">
             <label>Especialidad</label>
                  <select   id="bandas" name="bandas"class="custom-select d-block w-100" required="">
                    <option value="">- Seleccione -</option>
                    <?php foreach ($filas as $op): //llenar las opciones del primer select ?>
                    <option value="<?= $op['idespecialidades'] ?>"><?= $op['descripcion'] ?></option>  
                    <?php endforeach; ?>
                  </select>
      </div>
        <div class="col-md-6 mb-3">
            <label for="country">Especialista</label>
              <select id="discos" name="discos"  class="custom-select d-block w-100" disabled="" required="">
                <option value="">- Seleccione -</option>
              </select>
            </div>
               <!--  Opci&oacute;n seleccionada: <span style="font-weight: bold;" id="disco_sel"></span> -->
</div>
    <!-- Agregamos la libreria Jquery -->

         <div class="row">
   <div class="col-md-6 mb-3">
  <label>Fecha</label>
     <input class="form-control" type="date" value="" id="bandas_f" min="<?php echo $fecha_actual ?>" disabled="" name="bandas_f" required="" >
  </div>

 <div class="col-md-6 mb-3">
            <label for="country">Hora</label>
              <select id="discos_h" name="discos_h"  class="custom-select d-block w-100" disabled="" required="">
                <option value="">- Seleccione -</option>
              </select>
            </div>
<!--
 <div class="col-md-6 mb-3">
  <label >Time</label>
  <select id="hora" class="custom-select d-block w-100" name="hora">
      <?php 

     $fechaInicio = "07:00:00";
$fechaFin = "18:00:00";

# Fecha como segundos
$tiempoInicio = strtotime($fechaInicio);
$tiempoFin = strtotime($fechaFin);
#60 minutos por hora * 60 segundos por minuto
$hora = 3600;
$id_hora=1;
$conteo=1;
while($tiempoInicio <= $tiempoFin){
  # Podemos recuperar la fecha actual y formatearla
  # Más información: http://php.net/manual/es/function.date.php
  $fechaActual = date("H:i:s", $tiempoInicio);
  
  

  ?>

  <option value="<?php echo $fechaActual; ?>"> <?php echo $fechaActual;?> </option>
  <?php
  # Sumar el incremento para que en algún momento termine el ciclo
  $tiempoInicio += $hora;
  $id_hora += $conteo;
}

?>
  </select>
  </div>

-->

</div>
         

           <hr class="mb-4">
        <button class="btn btn-primary " type="submit" id="guardar" name="guardar"> Continuar</button>
        <?php  }   } else { ?>


         <div class="form-group">
    <label for="formGroupExampleInput">Nombres y Apellidos</label>
    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Aquí se mostraran sus nombres y apellidos" disabled="">
  </div>

          <?php
        include 'con_db.php';
        $con = conDb();
if(!$con){
  die("<br/>Sin conexi&oacute;n.");
  echo "error";
}

/*obtenemos los datos del primer select*/
$sql = "select * from especialidades";
$query = mysqli_query($con, $sql);
$filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
mysqli_close($con);


 ?>
    <div  class="row">
     <div class="col-md-6 mb-3">
             <label>Especialidad</label>
                  <select   id="bandas" class="custom-select d-block w-100" disabled="">
                    <option value="">- Seleccione -</option>
                    <?php foreach ($filas as $op): //llenar las opciones del primer select ?>
                    <option value="<?= $op['id_especialidad'] ?>"><?= $op['nombre_especialidad'] ?></option>  
                    <?php endforeach; ?>
                  </select>
      </div>
        <div class="col-md-6 mb-3">
            <label for="country">Especialista</label>
              <select id="discos"  class="custom-select d-block w-100" disabled="">
                <option value="">- Seleccione -</option>
              </select>
            </div>
                <!-- Opci&oacute;n seleccionada: <span style="font-weight: bold;" id="disco_sel"></span> -->
</div>

      <div class="row">
   <div class="col-md-6 mb-3">
  <label>Fecha</label> 
     <input class="form-control" type="date"  min="<?php echo $fecha_actual?>" id="fecha" disabled="">
   
  </div>

 <div class="col-md-6 mb-3">
  <label >Hora</label>
  <select id="hora" class="custom-select d-block w-100" disabled="" >
      <?php 

     $fechaInicio = "07:00:00";
$fechaFin = "18:00:00";

# Fecha como segundos
$tiempoInicio = strtotime($fechaInicio);
$tiempoFin = strtotime($fechaFin);
#60 minutos por hora * 60 segundos por minuto
$hora = 3600;
$id_hora=1;
$conteo=1;
while($tiempoInicio <= $tiempoFin){
  # Podemos recuperar la fecha actual y formatearla
  # Más información: http://php.net/manual/es/function.date.php
  $fechaActual = date("H:i:s A", $tiempoInicio);
  

  ?>

  <option value="<?php echo $fechaActual; ?>"  > <?php echo $fechaActual;  echo $id_hora;?> </option>
  <?php
  # Sumar el incremento para que en algún momento termine el ciclo
  $tiempoInicio += $hora;
  $id_hora += $conteo;
}

?>
  </select>
  </div>
</div>
         
        <hr class="mb-4">
        <button class="btn btn-primary " type="submit" id="guardar" disabled="">Enviar</button>
        <?php   }      ?>

      </form>
    </div>
  </div>
  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017-2020 Clínica Vitalia</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>
   

   <!-- copia este tambien -->
    <script src="form-validation.js"></script>
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!--hasta aqui -->

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="../recursoshumanos/components/scripts/dashboard.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- Iniciamos el segmento de codigo javascript -->
<!--    <script type="text/javascript">
      $(document).ready(function(){
        var discos = $('#discos');
        var disco_sel = $('#disco_sel');

        //Ejecutar accion al cambiar de opcion en el select de las bandas
        $('#bandas').change(function(){
          var banda_id = $(this).val(); //obtener el id seleccionado

          if(banda_id !== ''){ //verificar haber seleccionado una opcion valida

            /*Inicio de llamada ajax*/
            $.ajax({
              data: {banda_id:banda_id}, //variables o parametros a enviar, formato => nombre_de_variable:contenido
              dataType: 'html', //tipo de datos que esperamos de regreso
              type: 'POST', //mandar variables como post o get
              url: 'get_discos.php' //url que recibe las variables
            }).done(function(data){ //metodo que se ejecuta cuando ajax ha completado su ejecucion             

              discos.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax             
              discos.prop('disabled', false); //habilitar el select
            });
            /*fin de llamada ajax*/

          }else{ //en caso de seleccionar una opcion no valida
            discos.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            discos.prop('disabled', true); //deshabilitar el select
          }    
        });


        //mostrar una leyenda con el disco seleccionado
        $('#discos').change(function(){
          $('#disco_sel').html($(this).val() + ' - ' + $('#discos option:selected').text());
        });

      });
    </script> -->  

     <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
     
    <!-- Iniciamos el segmento de codigo javascript -->
    <script type="text/javascript">
      $(document).ready(function(){
         var discos = $('#discos');
        var disco_sel = $('#disco_sel');
        var discos_h = $('#discos_h');
        var bandas_f= $('#bandas_f');
      


         $('#bandas').change(function() {

      

            var banda_id = $(this).val(); //obtener el id seleccionado

          if(banda_id !== ''){ //verificar haber seleccionado una opcion valida

            /*Inicio de llamada ajax*/
            $.ajax({
              data: {banda_id:banda_id}, //variables o parametros a enviar, formato => nombre_de_variable:contenido
              dataType: 'html', //tipo de datos que esperamos de regreso
              type: 'POST', //mandar variables como post o get
              url: 'get_discos.php' //url que recibe las variables
            }).done(function(data){ //metodo que se ejecuta cuando ajax ha completado su ejecucion             

              discos.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax             
              discos.prop('disabled', false); //habilitar el select
              bandas_f.val('');
              discos_h.val('');
              discos_h.prop('disabled', true); //deshabilitar el select
              bandas_f.prop('disabled', true); //deshabilitar el select
            });
            /*fin de llamada ajax*/

          }else{ //en caso de seleccionar una opcion no valida
            discos.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select

            discos.prop('disabled', true); //deshabilitar el select
             discos_h.prop('disabled', true); //deshabilitar el select
              bandas_f.prop('disabled', true); //deshabilitar el select

          }    
      



          // body...

        $('#discos').change(function() {



          // body...
      
        var discos_hora = $(this).val();

        if (discos_hora !== '') {

           
              bandas_f.prop('disabled', false); //habilitar el select
              bandas_f.val('');
              discos_h.val('');
              discos_h.prop('disabled', true); //deshabilitar el select


         }else{ //en caso de seleccionar una opcion no valida
            bandas_f.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            bandas_f.prop('disabled', true); //deshabilitar el select
            discos_h.prop('disabled', true); //deshabilitar el select
       
          }


        //Ejecutar accion al cambiar de opcion en el select de las bandas
        $('#bandas_f').change(function(){



          var banda_id_f = $(this).val();
           //obtener el id seleccionado
         

          if(banda_id_f !== ''){ //verificar haber seleccionado una opcion valida

            /*Inicio de llamada ajax*/
            $.ajax({
              data: {banda_id_f:banda_id_f  , discos_hora: discos_hora , banda_id:banda_id }, //variables o parametros a enviar, formato => nombre_de_variable:contenido
              dataType: 'html', //tipo de datos que esperamos de regreso
              type: 'POST', //mandar variables como post o get
              url: 'hora_disponible.php' //url que recibe las variables
            }).done(function(data){ //metodo que se ejecuta cuando ajax ha completado su ejecucion             

              discos_h.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax             
              discos_h.prop('disabled', false); //habilitar el select
            });
            /*fin de llamada ajax*/

          }else{ //en caso de seleccionar una opcion no valida
            discos_h.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            discos_h.prop('disabled', true); //deshabilitar el select
       
            bandas_f.prop('disabled', true); //deshabilitar el select
          }
            });

          });

        });

      });
           

   //mostrar una leyenda con el disco seleccionado
   

     
    </script> 
</html>



