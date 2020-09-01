<?php 
require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';
require '../pacientes/components/LayoutPublic.php';  

session_start();

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

	$sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom FROM citas AS ci, pacientes AS pa, ciudades AS ciu, provincias AS pro, profesion_paciente AS pp, direccion_paciente AS dp WHERE (ci.paciente=pa.idpacientes AND pa.ciudad=ciu.idciudades AND ciu.provincia=pro.idprovincias AND pa.ocupacion_paciente=pp.idprofesion_paciente AND pa.idpacientes=dp.id_pacientes_de) AND ci.paciente='$cedula' and ci.idcitas='$citas'";


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
  </head>
  <body>
<?php
if ($_SESSION['nombre_credencial']=='Admin Ctas. Medicas' || $_SESSION['modulo_pacientes'] == 1 || $_SESSION['modulo_ctas_medicas'] == 1){
  ?>
  
   <nav class='navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow'>
   <a class='navbar-brand col-md-3 col-lg-2 mr-0 px-3' href='../pacientes/'>
   <span className='font-weight-bold'>Modulo</span>
   <span className='font-weight-ligth'>Pacientes</span>
   </a>
   <button class='navbar-toggler position-absolute d-md-none collapsed' type='button' data-toggle='collapse' data-target='#sidebarMenu' aria-controls='sidebarMenu' aria-expanded='false' aria-label='Toggle navigation'>
       <span class='navbar-toggler-icon'></span>
   </button>
   <ul class='navbar-nav px-3'>

   </ul>
   <a class='nav-link dropdown-toggle' style='color: white;' href='#' id='navbarDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
   <i class='fas fa-th-large' ></i>
   </a>
   <div class='dropdown-menu dropdown-menu-right mr-1 mb-2' style='width:400px;' aria-labelledby='navbarDropdownMenuLink'>
   <span class='dropdown-item font-weight-bold mb-2' style='text-align:center;'><?php echo $_SESSION['username']?></span>
   <hr class='ml-4 mr-4 mt-2'>
   <span class='dropdown-item font-weight-bold border-bottom border-info mb-2' style='text-align:center;'><?php echo $_SESSION['nombre_credencial']?></span>
   <?php  
      if($_SESSION['modulo_rrhh'] == 1){
      echo  "<a class='dropdown-item mt-2' href='../recursoshumanos/'><i class='fas fa-people-carry mr-2'></i> Recursos Humanos</a>";
      }
      if($_SESSION['modulo_suministros'] == 1){
      echo "<a class='dropdown-item' href='../suministro/'><i class='fas fa-dolly-flatbed mr-2'></i> Suministros</a>";
      }
      if($_SESSION['modulo_contabilidad'] == 1){
      echo "<a class='dropdown-item' href='../contabilidad/'><i class='fas fa-balance-scale mr-2'></i> Contabilidad</a>";
      }
      if($_SESSION['modulo_ctas_medicas'] == 1){
      echo "<a class='dropdown-item' href='../citasmedicas/'><i class='fas fa-notes-medical mr-3'></i> Citas Medicas</a>";
      }
      if($_SESSION['modulo_pacientes'] == 1){
      echo "<a class='dropdown-item' href='../pacientes/'><i class='fas fa-procedures mr-2'></i> Modulo Pacientes</a>";
      }
      if($_SESSION['modulo_seguridad'] == 1){
      echo "<a class='dropdown-item' href='../seguridad/'><i class='fas fa-user-shield mr-2'></i> Modulo Seguridad</a>";
      }
      if($_SESSION['paciente'] == 1){
      echo "<a class='dropdown-item' href='../pacientes/home.php'><i class='fas fa-procedures mr-2'></i> Paciente</a>";
      }
    ?>

   <hr class='ml-4 mr-4 mt-2'>
   <a class='dropdown-item mt-2' style='float:right;' href='../seguridad/routes/perfil.php'><span class='float-right'>Ajustes de Usuario</span></a>
   <a class='dropdown-item' style='float:right;' href='#'><span class='float-right'>Another</span></a>
   <a class='dropdown-item' style='float:right;' href='../seguridad/controllers/logout.php'><span class='float-right'>Cerrar Sesión</span></a>
   </div>
   </nav>

   <nav id='sidebarMenu' class='col-md-3 col-lg-2 d-md-block bg-light sidebar collapse'>
   <div class='sidebar-sticky pt-3'>
   <ul class='nav flex-column'>
   <li class='nav-item'>
   <a class='nav-link' href='../../../'>
   <span data-feather='home'></span>
   Pagina Principal <span class='sr-only'>(current)</span>
   </a>
   </li>
   <h6 class='sidebar-heading d-flex justify-content-around align-items-center px-3 mt-2 mb-2 text-muted'>
      <span data-feather='briefcase'></span>
      <span>Gestion Citas</span>
      <a class='d-flex align-items-center text-muted ml-3' href='#' aria-label='Add a new report'>
        <a data-toggle='collapse' href='#citas' role='button' aria-expanded='false' aria-controls='citas'>
            <span data-feather='plus-circle'></span></a>
      </a>
      </h6>
      <div class='collapse' id='citas'>
      <li class='nav-item ml-3'>
        <a class='nav-link active' href='historial_clinico.php'>
        <span data-feather='layers'></span>
        Historial de Citas
        </a>
        </li>
      <li class='nav-item ml-3'>
      <a class='nav-link' href='citas.php'>
      <span data-feather='layers'></span>
      Gestion de Citas
      </a>
      </li>
      </div>
      <h6 class='sidebar-heading d-flex justify-content-around align-items-center px-3 mt-2 mb-2 text-muted'>
      <span data-feather='briefcase'></span>
      <span>Pacientes</span>
      <a class='d-flex align-items-center text-muted ml-5' href='#' aria-label='Add a new report'>
        <a data-toggle='collapse' href='#collapsePacientes' role='button' aria-expanded='false' aria-controls='collapsePacientes'>
            <span data-feather='plus-circle'></span></a>
      </a>
      </h6>
      <div class='collapse' id='collapsePacientes'>
      <li class='nav-item ml-3'>
      <a class='nav-link' href='../pacientes/routes/registrar.php'>
      <span data-feather='briefcase'></span>
      Registrar
      </a>
      </li>
      <li class='nav-item ml-3'>
      <a class='nav-link' href='../pacientes/routes/visualizarPaciente.php'>
      <span data-feather='bar-chart-2'></span>
      Pacientes 
      </a>
      </li>
      <li class='nav-item ml-3'>
        <a class='nav-link' href='../pacientes/routes/pacientesBaja.php'>
        <span data-feather='layers'></span>
        Pacientes de baja
        </a>
        </li>
      </div>
      <h6 class='sidebar-heading d-flex justify-content-around align-items-center px-3 mt-2 mb-2 text-muted'>
   <span data-feather='briefcase'></span>
   <span> Laboratorio</span>
   <a class='d-flex align-items-center text-muted ml-3' href='#' aria-label='Add a new report'>
     <a data-toggle='collapse' href='#collapseExample' role='button' aria-expanded='false' aria-controls='collapseExample'>
          <span data-feather='plus-circle'></span></a>
   </a>
   </h6>
   <div class='collapse' id='collapseExample'>
      <li class='nav-item ml-3'>
      <a class='nav-link' href='../pacientes/routes/subirArchivo.php'>
      <span data-feather='layers'></span>
      Archivos
      </a>
      </li>
    </div>
   <li class='nav-item'>
   <a class='nav-link' href='../pacientes/routes/pagos.php'>
   <span data-feather='layers'></span>
   Pagos
   </a>
   </li>
   </ul>
   <ul class='nav flex-column mb-2'>

  
   </ul>
   </div>
   </nav>
   
<?php
}else{
  printLayout ('../pacientes/home.php', '../../../index.php', 'index.php', '../pacientes/routes/diagnostico.php', '../pacientes/routes/facturas.php','../seguridad/controllers/logout.php','../seguridad/routes/perfil.php','../pacientes/home.php',3);
}

?>
<div class="container-fluid">
  <div class="row">

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
      </div>

<?php 

$fecha_actual=date("Y-m-d");
 $tiempo=strtotime($fecha_actual);
 $nombre=$_SESSION['nombre_credencial'];


if (isset($_POST['buscar'])) {
  
  $cedula=$_POST['cedula_b'];
  $sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

join ciudades as ciu on  pa.ciudad=ciu.idciudades 
join provincias as pro on ciu.provincia=pro.idprovincias where pa.idpacientes='$cedula' order by ci.idcitas desc limit 1 ;
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
	
<?php if($_SESSION['nombre_credencial'] != 'PACIENTE'):?>
  <div class="col-md-3 mb-2" style="position: relative; left: -15px;">
      <label for="inputPassword2" class="sr-only">Buscar:</label>
      <input type="text" class="form-control" id="cedula_b" name="cedula_b" placeholder="Ingrese número de cédula">
  </div>
	<button  style="position: relative; top: -47px; left: 300px;" type="submit" class="btn btn-primary mb-3" id="buscar" name="buscar">Buscar</button>

	<a href="informacion.php? id_cedula=<?php  echo $cedula ?> " style="position: relative; top: -55px; left: 300px" class="btn btn-success">Citas anteriores</a>
<?php else:?>
  <a href="#" style="position: relative; top:67px; left:300px" class="btn btn-success">Citas</a>
<?php endif;?>

<br>
   <div  class="row">
   	 <div class="col-md-2 mb-3">
             <label>Cédula:</label>
                 <input type="" class="form-control" name="cedula" id="cedula" value="<?php echo $fila_b['paciente']; ?>"  readonly >
                 <input type="hidden" name="idcitas" id="idcitas" value="<?php echo $fila_b['idcitas']; ?>" readonly>
      </div>
     <div class="col-md-3 mb-3">
             <label>Nombres</label>
                 <input type="" class="form-control" name="" value="<?php echo utf8_decode($fila_b['nombres']); ?>" readonly >
      </div>
     <div class="col-md-3 mb-3">
            <label for="country">Apellidos</label>
             <input type="" class="form-control" name="" value="<?php echo utf8_encode($fila_b['ape_paterno']." ".$fila_b['ape_mat']);  ?>"  readonly>
     </div>

       <div class="col-md-3 mb-3">
            <label for="country">Ocupación</label>
             <input type="" class="form-control" name="" value="<?php echo utf8_encode($fila_b['profesion'])?>"  readonly>
     </div>

       <div class="col-md-1 mb-3">
            <label for="country">Sexo</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['sexo']?>" readonly >
     </div>
       <div class="col-md-2 mb-3">
            <label for="country">Fecha nacimiento</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['f_nacimiento']?>" readonly >
     </div>
   
   <?php if($fila_b['tipo']== 'Domicilio'):?>
       <div class="col-md-3 mb-3">
            <label for="country">Dirección</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['direccion']?>" readonly >
     </div>
   <?php endif;?>
     
       <div class="col-md-3 mb-3">
            <label for="country">Zona</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['zona']?>" readonly >
     </div> 
     <?php if($fila_b['tipo']== 'Domicilio'):?>
       <div class="col-md-2 mb-3">
            <label for="country">Teléfono</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['tlno_particular']?>" readonly >
      </div>

       <div class="col-md-2 mb-3">
            <label for="country">Celular</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['tlno_personal']?>" readonly >
     </div>
   <?php endif;?>
      
       <div class="col-md-4 mb-3">
            <label for="country">Correo electronico</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['correo']?>" readonly >
     </div>

	 <div class="col-md-3 mb-3">
            <label for="country">Afiliacion Publica</label>
             <input type="" class="form-control" name="" value="<?php if($fila_b['afiliacion_publica'] == null){ echo 'No tiene';} else { 
               $publica = $conn->query("SELECT * FROM seguro_publico AS sb, pacientes AS pa WHERE pa.afiliacion_publica=sb.idseguro_publico")->fetchAll(PDO::FETCH_OBJ);
               $conn = null;
               echo utf8_encode($publica[0]->descripcion);}?>" readonly >
     </div>

     <div class="col-md-2 mb-3">
            <label for="country">Afiliacion Privada</label>
             <input type="" class="form-control" name="" value="<?php if($fila_b['afiliacion_privada'] == null){ echo 'No tiene';} else { $privada = $conn->query("SELECT * FROM seguro_privado AS sv, pacientes AS pa WHERE pa.afiliacion_privada=sv.idseguro_privado")->fetchAll(PDO::FETCH_OBJ);
               $conn = null;
               echo utf8_encode($privada[0]->descripcion);}?>" readonly >
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../recursoshumanos/components/scripts/dashboard.js"></script>  
<!--hasta aqui -->
</body>
</html>