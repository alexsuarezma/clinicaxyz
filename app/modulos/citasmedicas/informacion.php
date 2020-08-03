<?php 
error_reporting(E_ALL ^ E_NOTICE);
require '../../../database.php';
require '../seguridad/controllers/functions/credenciales.php';



if ($_SESSION['nombre_credencial']=='paciente') {
 verificarAcceso("../../../", "paciente");
}

if ($_SESSION['nombre_credencial']=='Admin Ctas. Medicas') {
 verificarAcceso("../../../", "modulo_ctas_medicas");
}




include 'conexion.php';

 date_default_timezone_set('AMERICA/GUAYAQUIL');
$fila_b="";
$var="";

$cedula=$_GET['id_cedula'];
  $sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

join provincias as pro on pa.provincia=pro.idprovincias
join ciudades as ciu on  pa.ciudad=ciu.idciudades where pa.idpacientes='$cedula' order by idcitas ;
 ";
  $resultado_b=mysqli_query($conexion,$sentencia_buscar);
  $conteo=mysqli_num_rows($resultado_b);



if (isset($_POST['buscar'])) {
	
	$cedula=$_POST['cedula'];
	$sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

join provincias as pro on pa.provincia=pro.idprovincias
join ciudades as ciu on  pa.ciudad=ciu.idciudades where pa.idpacientes='$cedula' order by idcitas  ;
 ";
	$resultado_b=mysqli_query($conexion,$sentencia_buscar);
	$conteo=mysqli_num_rows($resultado_b);
	


	if ($conteo==0) {
		$var=' <div class="alert alert-danger" role="alert">
 Paciente no registrado!
</div> ';
	}


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

    <title>Consultar Cita</title>
    <link rel="icon" type="image/png" href="logo1.png" />
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<LINK REL=StyleSheet HREF="formulario.css" TYPE="text/css" MEDIA=screen>
</head>
<body>
<br><br>
<center>	<h2>Historial clínico</h2></center>
<br><br>

<?php  echo $var; ?>

<form style="  width: 90%; position: relative; left: 60px;" action="informacion.php" method="POST" >


<div class="col-md-3 mb-2" style="position: relative; left: -15px;">
    <label for="inputPassword2" class="sr-only">Buscar:</label>
    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Ingrese número de cédula">
</div>
	<button  style="position: relative; top: -47px; left: 300px;" type="submit" class="btn btn-primary mb-3" id="buscar" name="buscar">Buscar</button>



<br>
</form>
<center>
<table class="table" style="width: 1000px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Editar</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    while ($fila_b=mysqli_fetch_array($resultado_b)) {
      $id_paciente=$fila_b['idpacientes'];
      
      ?>
    <tr>
      <th scope="row"><?php echo $fila_b['idcitas']; ?>  </th>
      <td><?php echo $fila_b['nombres']; ?> </td>
      <td><?php echo $fila_b['ape_paterno']." ".$fila_b['ape_mat'] ; ?> </td>
      <td> <a href="historial_clinico.php? id_paciente=<?php echo $id_paciente; ?> & id_citas=<?php echo $fila_b['idcitas'] ?> ">Ver</a></td>
    </tr>
  

      <?php
    }
    ?>
  </tbody>
</table>
</center>
</body>
</html>