<?php 
  require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';






error_reporting(E_ALL ^ E_NOTICE);
include 'conexion.php';

if ($_SESSION['nombre_credencial']=='PACIENTE') {
 verificarAcceso("../../../", "paciente");
}

if ($_SESSION['nombre_credencial']=='Admin Ctas. Medicas') {
 verificarAcceso("../../../", "modulo_ctas_medicas");
}

date_default_timezone_set('AMERICA/GUAYAQUIL');
$fila_b="";
$var="";




$cedula=$_GET['id_paciente'];
$citas=$_GET['id_citas'];
	$sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

join provincias as pro on pa.provincia=pro.idprovincias
join ciudades as ciu on  pa.ciudad=ciu.idciudades where ci.paciente='$cedula' and ci.idcitas='$citas'
 ";
	$resultado_b=mysqli_query($conexion,$sentencia_buscar);
	$conteo=mysqli_num_rows($resultado_b);
	$fila_b=mysqli_fetch_array($resultado_b);





if (isset($_POST['guardar'])) {
$id_paciente=$_POST['cedula'];
$id_cita=$_POST['idcitas'];
$observacion=$_POST['observacion'];
$tratamiento=$_POST['tratamiento'];
$medicamento=$_POST['medicamento'];

$sentencia="UPDATE citas 
SET observaciones = '$observacion' , tratamiento='$tratamiento' , medicamentos='$medicamento'
WHERE idcitas='$id_cita'  and paciente='$id_paciente' ";

mysqli_query($conexion,$sentencia);

 	    		  echo ("<script LANGUAGE='JavaScript'>
    window.alert('Modificado con exito! ');
    window.location.href='historial_clinico.php ';
    </script>");
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Historial clínico</title>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="icon" type="image/png" href="logo1.png" />
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">


    
  <!-- copia este!!! -->   <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<LINK REL=StyleSheet HREF="formulario.css" TYPE="text/css" MEDIA=screen>
</head>
<body>
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

                echo "<a class='dropdown-item' href='historial_clinico.php'><i class='fas fa-notes-medical mr-3'></i>Historial clinico</a>";
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


<?php 

$fecha_actual=date("Y-m-d");
 $tiempo=strtotime($fecha_actual);
 $nombre=$_SESSION['nombre_credencial'];


if (isset($_POST['buscar'])) {
  
  $cedula=$_POST['cedula_b'];
  $sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

join provincias as pro on pa.provincia=pro.idprovincias
join ciudades as ciu on  pa.ciudad=ciu.idciudades where pa.idpacientes='$cedula' order by ci.idcitas desc limit 1 ;
 ";
  $resultado_b=mysqli_query($conexion,$sentencia_buscar);
  $conteo=mysqli_num_rows($resultado_b);
  $fila_b=mysqli_fetch_array($resultado_b);


  if ($conteo==0) {
    $var=' <div class="alert alert-danger" role="alert">
 Paciente no registrado!
</div> ';
  }


}

 $tiempo_res=strtotime($fila_b['fecha']);

if ($tiempo>$tiempo_res or $nombre=='PACIENTE'  ) {
  $mostrar="readonly";
}else{
  $mostrar="";

  }

?>


<br><br>
<center><h2>Historial Clínico  </h2></center>
<br><br>

<?php 

echo $var;

?>


<form style="width: 90%; position: relative; left: 60px;" action="historial_clinico.php" method="POST" >

<content style="width: 100%;">
	<div style="position: relative; float: right;">
		<label> <b>Fecha de cita:</b> <?php if (  $fila_b=="") {
			echo "................";
		}else { echo  $fila_b['fecha']; 
		} ?>
	</label>
		<label><b> Hora de cita: </b> <?php if ( $fila_b=="") {
			echo "................";
		}else { echo  $fila_b['id_hora']; 
		} ?></label>
	</div>
	

<div class="col-md-3 mb-2" style="position: relative; left: -15px;">
    <label for="inputPassword2" class="sr-only">Buscar:</label>
    <input type="text" class="form-control" id="cedula_b" name="cedula_b" placeholder="Ingrese número de cédula">
</div>
	<button  style="position: relative; top: -47px; left: 300px;" type="submit" class="btn btn-primary mb-3" id="buscar" name="buscar">Buscar</button>

	<a href="informacion.php? id_cedula=<?php  echo $cedula ?> " style="position: relative; top: -55px; left: 300px" class="btn btn-success"  >Citas anteriores</a>
<br>
   <div  class="row">
   	 <div class="col-md-2 mb-3">
             <label>Cédula:</label>
                 <input type="" class="form-control" name="cedula" id="cedula" value="<?php echo $fila_b['paciente']; ?>"  readonly >
                 <input type="hidden" name="idcitas" id="idcitas" value="<?php echo $fila_b['idcitas']; ?>" readonly>
      </div>
     <div class="col-md-3 mb-3">
             <label>Nombres</label>
                 <input type="" class="form-control" name="" value="<?php echo $fila_b['nombres']; ?>" readonly >
      </div>
     <div class="col-md-3 mb-3">
            <label for="country">Apellidos</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['ape_paterno']." ".$fila_b['ape_mat'];  ?>"  readonly>
     </div>

       <div class="col-md-3 mb-3">
            <label for="country">Ocupación</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['ocupacion']?>"  readonly>
     </div>

       <div class="col-md-1 mb-3">
            <label for="country">Sexo</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['sexo']?>" readonly >
     </div>
       <div class="col-md-2 mb-3">
            <label for="country">Fecha nacimiento</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['f_nacimiento']?>" readonly >
     </div>
   
       <div class="col-md-3 mb-3">
            <label for="country">Dirección</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['direccion']?>" readonly >
     </div>

     
       <div class="col-md-3 mb-3">
            <label for="country">Zona</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['zona']?>" readonly >
     </div> 
       <div class="col-md-2 mb-3">
            <label for="country">Teléfono</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['tlno_particular']?>" readonly >
     </div>

       <div class="col-md-2 mb-3">
            <label for="country">Celular</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['tlno_personal']?>" readonly >
     </div>
      
       <div class="col-md-4 mb-3">
            <label for="country">Correo electronico</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['correo']?>" readonly >
     </div>

	 <div class="col-md-1 mb-3">
            <label for="country">Afiliado</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['afiliado']?>" readonly >
     </div>
      <div class="col-md-3 mb-3">
            <label for="country">Ciudad</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['ci_nom']?>" readonly >
     </div>
     <div class="col-md-2 mb-3">
            <label for="country">Provincia</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['pro_nom']?>" readonly >
     </div>
    
      <div class="col-md-2 mb-3">
            <label for="country">Estado</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['estado']?>" readonly  >
     </div>

     <div class=" col-md-6 mb-3">
            <label for="validationTextarea">Diagnóstico</label>
     <textarea class="form-control" id="observacion" <?php echo $mostrar;?> name="observacion"  ><?php  echo $fila_b['observaciones'] ?> </textarea>
     </div>
     
     <div class="col-md-6 mb-3">
            <label for="validationTextarea">Tratamiento</label>
     <textarea class="form-control" id="tratamiento" <?php echo $mostrar;?> name="tratamiento"   ><?php  echo $fila_b['tratamiento'] ?> </textarea>
     </div>

     <div class="col-md-6 mb-3">
            <label for="validationTextarea">Medicamentos</label>
            <textarea class="form-control" id="medicamento" <?php echo $mostrar;?> name="medicamento" placeholder="Escriba el medicamento"   > <?php  echo $fila_b['medicamentos'] ?> </textarea>
     </div>
</div>
<br><br><br>

<a href="reportes/mostrar_historica.php? id_paciente=<?php echo $fila_b['idpacientes'];?> & id_citas=<?php echo $fila_b['idcitas']; ?> " target="_Blank" class="btn btn-primary">Imprimir</a>

<?php if ($nombre=='PACIENTE') {
    # code...

 ?>
<?php } else {  ?>


<button type="submit" class="btn btn-success" name="guardar" id="guardar"> Guardar </button>


<?php  } ?>
</content>
</form>
<br>
   <!-- copia este tambien -->
    <script src="form-validation.js"></script>
   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!--hasta aqui -->
</body>
</html>