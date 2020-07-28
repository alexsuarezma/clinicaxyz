<?php 
error_reporting(E_ALL ^ E_NOTICE);
include 'conexion.php';

date_default_timezone_set('AMERICA/GUAYAQUIL');
$fila_b="";
$var="";


$cedula=$_GET['id_paciente'];
$citas=$_GET['id_citas'];
	$sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes
join hora as ho on ci.id_hora=ho.id_hora
join provincias as pro on pa.provincia=pro.idprovincias
join ciudades as ciu on  pa.ciudad=ciu.idciudades where ci.paciente='$cedula' and ci.idcitas='$citas'
 ";
	$resultado_b=mysqli_query($conexion,$sentencia_buscar);
	$conteo=mysqli_num_rows($resultado_b);
	$fila_b=mysqli_fetch_array($resultado_b);



if (isset($_POST['buscar'])) {
	
	$cedula=$_POST['cedula_b'];
	$sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes
join hora as ho on ci.id_hora=ho.id_hora
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
	<title>Historial clinico</title>
    <meta charset="utf-8">
     <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Consultar Cita</title>
    <link rel="icon" type="image/png" href="logo1.png" />
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<LINK REL=StyleSheet HREF="formulario.css" TYPE="text/css" MEDIA=screen>
</head>
<body>
<br><br>
<center>	<h2>Historial clinico del paciente</h2></center>
<br><br>

<?php  echo $var;  
$fecha_actual=date("Y-m-d");
 $tiempo=strtotime($fecha_actual);
 $tiempo_res=strtotime($fila_b['fecha']);


if ($tiempo>$tiempo_res) {
	$mostrar="readonly";
}else{
	$mostrar="";
}
?>

<form style="  width: 90%; position: relative; left: 60px;" action="Historial_clinico.php" method="POST" >

<content style="width: 100%;">
	<div style="position: relative; float: right;">
		<label> <b>Fecha de cita:</b> <?php if (  $fila_b=="") {
			echo "................";
		}else { echo  $fila_b['fecha']; 
		} ?>
	</label>
		<label><b> Hora de cita: </b> <?php if ( $fila_b=="") {
			echo "................";
		}else { echo  $fila_b['hora']; 
		} ?></label>
	</div>
	

<div class="col-md-3 mb-2" style="position: relative; left: -15px;">
    <label for="inputPassword2" class="sr-only">Buscar:</label>
    <input type="text" class="form-control" id="cedula_b" name="cedula_b" placeholder="Ingrese # Cedula">
</div>
	<button  style="position: relative; top: -47px; left: 300px;" type="submit" class="btn btn-primary mb-3" id="buscar" name="buscar">Buscar</button>

	<a href="informacion.php? id_cedula=<?php  echo $cedula ?> " style="position: relative; top: -55px; left: 300px" class="btn btn-success"  >Citas anteriores</a>



<br>


   <div  class="row">
   	 <div class="col-md-2 mb-3">
             <label>Cedula:</label>
                 <input type="" class="form-control" name="cedula" id="cedula" value="<?php echo $fila_b['paciente']; ?>"  readonly >
                 <input type="hidden" name="idcitas" id="idcitas" value="<?php echo $fila_b['idcitas']; ?>" readonly>
      </div>
     <div class="col-md-3 mb-3">
             <label>Nombre:</label>
                 <input type="" class="form-control" name="" value="<?php echo $fila_b['nombres']; ?>" readonly >
      </div>
     <div class="col-md-3 mb-3">
            <label for="country">Apellidos</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['ape_paterno']." ".$fila_b['ape_mat'];  ?>"  readonly>
     </div>

       <div class="col-md-3 mb-3">
            <label for="country">Ocupacion</label>
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
            <label for="country">Direccion</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['direccion']?>" readonly >
     </div>

     
       <div class="col-md-3 mb-3">
            <label for="country">Zona</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['zona']?>" readonly >
     </div> 
       <div class="col-md-2 mb-3">
            <label for="country">Telefono</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['tlno_particular']?>" readonly >
     </div>

       <div class="col-md-2 mb-3">
            <label for="country">Celular personal</label>
             <input type="" class="form-control" name="" value="<?php echo $fila_b['tlno_personal']?>" readonly >
     </div>
      
       <div class="col-md-4 mb-3">
            <label for="country">Correo</label>
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
    <label for="validationTextarea">Observacion</label>
    <textarea class="form-control" id="observacion" <?php echo $mostrar;?> name="observacion"  ><?php  echo $fila_b['observaciones'] ?> </textarea>
    
     </div>
	 <div class="col-md-6 mb-3">
    <label for="validationTextarea">Tratamiento</label>
    <textarea class="form-control" id="tratamiento" <?php echo $mostrar;?> name="tratamiento"   ><?php  echo $fila_b['tratamiento'] ?> </textarea>
    
     </div>
      <div class="col-md-6 mb-3">
    <label for="validationTextarea">Medicamento</label>
    <textarea class="form-control" id="medicamento" <?php echo $mostrar;?> name="medicamento" placeholder="Escriba el medicamento"   > <?php  echo $fila_b['medicamentos'] ?> </textarea>
   
  	</div>




</div>
<br><br><br>

<!--<a href="reportes/mostrar_historica.php? id_paciente=<?php echo $fila_b['idpacientes'];?> & id_citas=<?php echo $fila_b['idcitas']; ?> " class="btn btn-primary">Imprimir</a>-->
<button type="submit" class="btn btn-success" name="guardar" id="guardar">Guardar</button>


</content>
<br><br>






</form>




</body>
</html>