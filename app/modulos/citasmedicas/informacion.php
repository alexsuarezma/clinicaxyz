<?php 
error_reporting(E_ALL ^ E_NOTICE);
require '../../../database.php';
require '../pacientes/components/LayoutPublic.php';  
require '../seguridad/controllers/functions/credenciales.php';

session_start();

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

$sentencia_buscar = "SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom FROM citas AS ci, pacientes AS pa, ciudades AS ciu, provincias AS pro, profesion_paciente AS pp, direccion_paciente AS dp WHERE (ci.paciente=pa.idpacientes AND pa.ciudad=ciu.idciudades AND ciu.provincia=pro.idprovincias AND pa.ocupacion_paciente=pp.idprofesion_paciente AND pa.idpacientes=dp.id_pacientes_de) AND pa.idpacientes='$cedula' order by idcitas";


//   $sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

// join provincias as pro on pa.provincia=pro.idprovincias
// join ciudades as ciu on  pa.ciudad=ciu.idciudades where pa.idpacientes='$cedula' order by idcitas ;
//  ";
  $resultado_b=mysqli_query($conexion,$sentencia_buscar);
  $conteo=mysqli_num_rows($resultado_b);



if (isset($_POST['buscar'])) {
	
	$cedula=$_POST['cedula'];
// 	$sentencia_buscar="SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom from citas as ci join pacientes as pa on ci.paciente=pa.idpacientes

// join provincias as pro on pa.provincia=pro.idprovincias
// join ciudades as ciu on  pa.ciudad=ciu.idciudades where pa.idpacientes='$cedula' order by idcitas  ;
//  ";

$sentencia_buscar = "SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom FROM citas AS ci, pacientes AS pa, ciudades AS ciu, provincias AS pro, profesion_paciente AS pp, direccion_paciente AS dp WHERE (ci.paciente=pa.idpacientes AND pa.ciudad=ciu.idciudades AND ciu.provincia=pro.idprovincias AND pa.ocupacion_paciente=pp.idprofesion_paciente AND pa.idpacientes=dp.id_pacientes_de) AND pa.idpacientes='$cedula' order by idcitas";


	$resultado_b=mysqli_query($conexion,$sentencia_buscar);
	$conteo=mysqli_num_rows($resultado_b);
	


	if ($conteo==0) {
		$var=' <div class="alert alert-danger" role="alert">
 Paciente no registrado!
</div> ';
	}


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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../recursoshumanos/components/scripts/dashboard.js"></script>  
</body>
</html>