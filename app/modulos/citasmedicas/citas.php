<?php 
error_reporting(E_ALL ^ E_NOTICE);
require '../../../database.php';
require '../pacientes/components/LayoutAdmin.php';
require '../seguridad/controllers/functions/credenciales.php';

session_start();

if($_SESSION['modulo_pacientes'] != 1 && $_SESSION['modulo_ctas_medicas'] != 1){
  header('Location: ../pacientes/');
}

// verificarAcceso("../../../", "modulo_ctas_medicas");



 date_default_timezone_set('AMERICA/GUAYAQUIL');
include "conexion.php";

$fecha_actual= date("Y-m-d");

$hora_actual=date("H:i:s");

function tiempo_session()
{
  include "conexion.php";
  
   if($hora_actual>$hora_cita) {

        //Tiempo en segundos para dar vida a la sesión.
        $inactivo = 1200;//20min en este caso.

        //Calculamos tiempo de vida inactivo.
        $vida_session = time() - $_SESSION['tiempo'];

            //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
            if($vida_session > $inactivo)
            {
                //Removemos sesión.
                session_unset();
                //Destruimos sesión.
                session_destroy();              
                //Redirigimos pagina.
                header("Location: iniciar_session.php");

                exit();
            }

    }
    $_SESSION['tiempo'] = time();

  
}


$cedula_d=$_SESSION['cedula_d'];
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
    <link href="../recursoshumanos/assets/styles/component/dashboard.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="logo1.png" />
  <script type="text/javascript">
    function preguntar(p1){
     var p1;
     eliminar=confirm("¿Deseas eliminar este registro?");
     if (eliminar)
     //Redireccionamos si das a aceptar
   
       window.location.href="eliminar.php?Id="+p1; //página web a la que te redirecciona si confirmas la eliminación
  else
    //Y aquí pon cualquier cosa que quieras que salga si le diste al boton de cancelar
      alert('No se ha podido eliminar el registro...')
  }
  </script>
  </head>
  <body>
  <?php
    printLayout ('../pacientes/index.php', '../../../index.php', '../pacientes/routes/registrar.php', 'historial_clinico.php','citas.php', '../pacientes/routes/visualizarPaciente.php', '../pacientes/routes/pacientesBaja.php', '../pacientes/routes/pagos.php','../pacientes/routes/subirArchivo.php',
    '../seguridad/controllers/logout.php','../seguridad/routes/perfil.php','../recursoshumanos/','../suministro/','../contabilidad/','../citasmedicas/','index.php','../seguridad/',3);
  ?>  
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>




<br><br>
<h2 class="" style="text-align:center;">Citas agendadas</h2>
<center>
  <table class="table table-striped" style="position: relative; top: 80px; width: 90%">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Cédula</th>
      <th scope="col">Fecha</th>
      <th scope="col">Hora</th>
      <th scope="col">Especialidad</th>
      <th scope="col">Especialista</th>
      <th scope="col">Estado</th>
      <th scope="col">Editar</th>
      <th scope="col">Cancelar</th>
      <th scope="col">Generar</th>
      <th scope="col">Generar</th>

         <!--<th scope="col">Eliminar</th>  -->
    </tr>
  </thead>
  <tbody>

    <tr>
    <?php
  
    include "conexion.php";
    $sentencia="SELECT * FROM citas_medica where fecha='$fecha_actual' order by idcitas";


$result=mysqli_query($conexion, $sentencia);

if($result){
  
  while ($row = mysqli_fetch_array($result)){   
    ?>
    <th><?php echo $row['idcitas'] ?> </th>
    <th><?php echo $row['nombres'] ?> </th>
    <th><?php echo utf8_decode($row['ape_paterno'])." ".utf8_decode($row['ape_mat']) ?> </th>
    <th><?php echo $row['idpacientes'] ?> </th>
    <th><?php echo $row['fecha'] ?> </th>
    <th><?php echo $row['id_hora'] ?> </th>
    <th><?php echo $row['descripcion'] ?> </th>
    <th><?php echo utf8_decode($row['nombreD'])." ".utf8_decode($row['apellidos']); ?> </th> 
    <th><?php echo $row['estado'] ?> </th>



    <?php 
    $id_paciente=$row['id_paciente'] ?? '';
    $id_cita=$row['idcitas'];

    
    if ($hora_actual>$row['id_hora']) {
      
      $sql_cambio="UPDATE citas
SET  estado='No realizado'
WHERe idcitas=$id_cita and estado='Pendiente'";

mysqli_query($conexion,$sql_cambio);
}elseif ($hora_actual<$row['id_hora']) {
   $sql_cambio="UPDATE citas
SET  estado='Pendiente'
WHERe idcitas=$id_cita and estado='No realizado'";

mysqli_query($conexion,$sql_cambio);
}

if ($row['estado']=='Pendiente') {
  # code...
  
    ?>


    <th> <a href="cambiar_estado.php?paciente=<?php echo $id_cita ?> " > <img src="verificardor.jpg" style="width: 30px; height: 20px; border-radius:50px;"></a> </th>
     <th><button type="button" name="" id="" class="btn btn-danger"  onClick="return preguntar(<?php echo $row['idcitas']; ?>)"> Cancelar</button></th>

      <th> <?php echo "<button type='button' class='btn btn-primary openBtn' data-toggle='modal' onclick='enviar_dato(".$row['idcitas'].")'  data-target='.bd-example-modal-lg'>Certificado</button>" ?> </th>
      <th> <a href="reportes/imprimir_receta.php?id_cita=<?php echo $id_cita ?>" target='_Blank'> <button class="btn btn-primary">  Receta </button></a> </th>

<?php }elseif ($row['estado']=='Realizado') {
  # code...
  ?>

  <th> <a href="cambiar_estado.php?paciente=<?php echo $id_cita ?> " > <img src="anular.jpg" style="width: 30px; height: 20px; border-radius:50px;"></a> </th>
    <th><button type="button" name="" id="" class="btn btn-danger"  onClick="return preguntar(<?php echo $row['idcitas']; ?>)"> Cancelar</button></th>
     <th> <?php echo "<button type='button' class='btn btn-primary openBtn' data-toggle='modal' onclick='enviar_dato(".$row['idcitas'].")'  data-target='.bd-example-modal-lg' disabled='' >Certificado</button>" ?> </th>
<th> <a href="reportes/imprimir_receta.php?id_cita=<?php echo $id_cita ?>"> <button class="btn btn-primary" disabled="">  Receta </button></a> </th>


<?php }elseif ($row['estado']=='No realizado') { ?>
  
  <th> <a href onclick="alert('Cita no realizada');"> <img src="no_realizado.png" style="width: 30px; height: 20px; border-radius:50px;"></a> </th>
   <th><button type="button" name="" id="" class="btn btn-danger"  onClick="return preguntar(<?php echo $row['idcitas']; ?>)"> Cancelar</button></th>
    <th> <?php echo "<button type='button' class='btn btn-primary openBtn' data-toggle='modal' onclick='enviar_dato(".$row['idcitas'].")'  data-target='.bd-example-modal-lg' disabled='' >Certificado</button>" ?> </th>
   <th> <a href="reportes/imprimir_receta.php?id_cita=<?php echo $id_cita ?>"> <button class="btn btn-primary" disabled="">  Receta </button></a> </th>
<?php }elseif ($row['estado']=='Cancelado' ) { ?>
  
  <th> Cita cancelada</th>
  <!--<th> <a href=""> <img src="eliminar.png" style="width: 30px; height: 20px; border-radius: 50px;"></a> </th> -->  
  <th>Cancelada</th>
    <th> <?php echo "<button type='button' class='btn btn-primary openBtn' data-toggle='modal' onclick='enviar_dato(".$row['idcitas'].")'  data-target='.bd-example-modal-lg' disabled='' >Certificado</button>" ?> </th>
   <th> <a href="reportes/imprimir_receta.php?id_cita=<?php echo $id_cita ?>" > <button class="btn btn-primary" disabled="">  Receta </button></a> </th>
<?php } ?>
  </tr>
<?php } 
}  ?>   


  </tbody>
</table>
</center>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center><h4>Detalles</h4></center>

        <button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><br>
        
        </div>
        <div class="modal-body">
             <div id="panel_selector"></div>
        </div>
    </div>
  </div>
</div>

<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script type="text/javascript" src="js/funciones_ad.js">     </script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../recursoshumanos/components/scripts/dashboard.js"></script>

</body>
</html>