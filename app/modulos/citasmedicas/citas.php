<?php 
error_reporting(E_ALL ^ E_NOTICE);
require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';


verificarAcceso("../../../", "modulo_ctas_medicas");

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
<html>
<head>
  <title>Citas agendadas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">
    <link rel="icon" type="image/png" href="logo1.png" />

    
  <!-- copia este!!! -->   <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->

<LINK REL=StyleSheet HREF="formulario.css" TYPE="text/css" MEDIA=screen>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>

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


   <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="../../../index.php">
      <span style="font-weight:normal;">Clinica</span>
      <span style="font-weight:bold;">Vitalia</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
        
        </li>
      </ul>

      <?php 
        session_start();
        
          if(!empty($_SESSION['user_id'])): 
            require '../../../database.php';
                $credenciales = $conn->query("SELECT * FROM usuario_credencial WHERE id_usuario_uc =".$_SESSION['user_id'])->fetchAll(PDO::FETCH_OBJ);
                $_SESSION['modulo_rrhh'] = 0;
                $_SESSION['modulo_suministros'] = 0;
                $_SESSION['modulo_contabilidad'] = 0;
                $_SESSION['modulo_ctas_medicas'] = 0;
                $_SESSION['modulo_pacientes'] = 0;
                $_SESSION['modulo_seguridad'] = 0;
                $_SESSION['paciente'] = 0;
                $_SESSION['nombre_credencial'] = "";
                
                foreach ($credenciales as $idCredencial){ 

                    $records = $conn->prepare("SELECT * FROM usuario_credencial AS uc, credencial_base AS c, usuario AS u WHERE (uc.id_credencialbase_uc = c.id_credencial AND uc.id_usuario_uc = u.id_usuario) AND id_usuario_credencial = :id_usuario_credencial");
                    $records->bindParam(':id_usuario_credencial', $idCredencial->id_usuario_credencial);
                    $records->execute();
                    $results = $records->fetch(PDO::FETCH_ASSOC); 
                    if($results['modulo_rrhh'] == 1){
                      $_SESSION['modulo_rrhh'] = 1;
                    }
                    if($results['modulo_suministros'] == 1){
                      $_SESSION['modulo_suministros'] = 1;
                    }
                    if($results['modulo_contabilidad'] == 1){
                      $_SESSION['modulo_contabilidad'] = 1;
                    }
                    if($results['modulo_ctas_medicas'] == 1){
                      $_SESSION['modulo_ctas_medicas'] = 1;
                    }
                    if($results['modulo_pacientes'] == 1){
                      $_SESSION['modulo_pacientes'] = 1;
                    }
                    if($results['paciente'] == 1){
                      $_SESSION['paciente'] = 1;
                    }
                    if($results['modulo_seguridad'] == 1) {
                      $_SESSION['modulo_seguridad'] = 1;
                    }
                    if($_SESSION['nombre_credencial'] == ""){
                      $_SESSION['nombre_credencial'] = strtoupper($results['nombre_credencial']);
                    }else{
                      $_SESSION['nombre_credencial'] = $_SESSION['nombre_credencial'].", ".strtoupper($results['nombre_credencial']);
                    }
                }
                
                $_SESSION['username'] = ucwords($results['username']);
                

      ?>
          
          <span class="navbar-text mr-4"><?php echo $_SESSION['username']?></span>
          <a class='nav-link dropdown-toggle' style='color: white;' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            <i class="fas fa-th-large" ></i>
          </a>  
          <div class='dropdown-menu dropdown-menu-right mr-1 mb-2' style="width:400px;" aria-labelledby='navbarDropdownMenuLink'>
            <span class="dropdown-item font-weight-bold border-bottom border-info mb-2" style="text-align:center;"><?php echo $_SESSION['nombre_credencial']?></span>
            <?php
              if($_SESSION['modulo_rrhh'] == 1){
                echo "<a class='dropdown-item mt-2' href='../recursoshumanos/'><i class='fas fa-people-carry mr-2'></i> Recursos Humanos</a>";
              }
              if($_SESSION['modulo_suministros'] == 1){
                echo "<a class='dropdown-item' href='../suministro/index.php'><i class='fas fa-dolly-flatbed mr-2'></i> Suministros</a>";
              }
              if($_SESSION['modulo_contabilidad'] == 1){
                echo "<a class='dropdown-item' href='../contabilidad/index.php'><i class='fas fa-balance-scale mr-2'></i> Contabilidad</a>";
              }
              if($_SESSION['modulo_ctas_medicas'] == 1){
                echo "<a class='dropdown-item' href='../citasmedicas/citas.php'><i class='fas fa-notes-medical mr-3'></i> Citas agendadas</a>";
                echo "<a class='dropdown-item' href='../citasmedicas/historial_clinico.php'><i class='fas fa-notes-medical mr-3'></i>Historial clinico</a>";
              }
              if($_SESSION['modulo_pacientes'] == 1){
                echo "<a class='dropdown-item' href='../pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
              }
              if($_SESSION['modulo_seguridad'] == 1){
                echo "<a class='dropdown-item' href='../seguridad/'><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
              }
              if($_SESSION['paciente'] == 1){
                echo "<a class='dropdown-item' href='../pacientes/index copy 2.html'><i class='fas fa-procedures mr-2'></i> Paciente</a>";

                echo "<a class='dropdown-item' href='index.php'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";

                echo "<a class='dropdown-item' href='historial_clinico.php'><i class='fas fa-notes-medical mr-3'></i>Historial clínico</a>";
              }
              
            ?>            
            <!-- <a class='dropdown-item' href='#'><i class='fas fa-file-medical-alt mr-3'></i> Historial Clinico</a> -->
            <hr class="ml-4 mr-4 mt-2">
            <a class='dropdown-item mt-2' style="float:right;" href='../seguridad/routes/perfil.php'><span class="float-right">Ajustes de Usuario</span></a>
            <a class='dropdown-item' style="float:right;" href='#'><span class="float-right">Another</span></a>
            <a class='dropdown-item' style="float:right;" href='../seguridad/controllers/logout.php'><span class="float-right">Cerrar Sesión</span></a>
          </div>
       
      <?php else: ?>
        <span class="navbar-text">
          <a class='' href='app/modulos/seguridad/routes/login.php'>Iniciar sesión</a>
        </span>   
      <?php endif; ?>
      
      <!-- <li class='justify-content-end'>
        
      </li> -->
    </div>
  </nav>
</header>
<br><br>

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
    $sentencia="SELECT * FROM citas_medica where fecha='$fecha_actual' and id_empleados='$cedula_d' order by idcitas";


$result=mysqli_query($conexion, $sentencia);
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
<?php }   ?>   


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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


</body>
</html>