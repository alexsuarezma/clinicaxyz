<?php 
require '../pacientes/components/LayoutPublic.php';  
require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';

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
	$sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

join ciudades as ciu on  pa.ciudad=ciu.idciudades 
join provincias as pro on ciu.provincia=pro.idprovincias where ci.paciente='$cedula' and ci.idcitas='$citas'
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
printLayout ('../pacientes/home.php', '../../../index.php', 'index.php', 'historial_clinico.php', '#','../seguridad/controllers/logout.php','../seguridad/routes/perfil.php','../pacientes/home.php',3);
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../recursoshumanos/components/scripts/dashboard.js"></script>  
<!--hasta aqui -->
</body>
</html>