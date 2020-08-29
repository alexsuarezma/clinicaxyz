<?php 
error_reporting(E_ALL ^ E_NOTICE);
require '../../../../database.php';
require '../components/LayoutPublic.php';  
require '../../seguridad/controllers/functions/credenciales.php';

session_start();

if (strtolower($_SESSION['nombre_credencial'])=='paciente') {
 verificarAcceso("../../../../", "paciente");
}

$citas = $conn->query("SELECT *,ciu.nombre as ci_nom,pro.nombre as pro_nom FROM citas AS ci, pacientes AS pa, ciudades AS ciu, provincias AS pro, profesion_paciente AS pp, direccion_paciente AS dp WHERE (ci.paciente=pa.idpacientes AND pa.ciudad=ciu.idciudades AND ciu.provincia=pro.idprovincias AND pa.ocupacion_paciente=pp.idprofesion_paciente AND pa.idpacientes=dp.id_pacientes_de) AND pa.idpacientes='".$_SESSION['cedula_d']."' ORDER BY ci.fecha DESC")->fetchAll(PDO::FETCH_OBJ);
$conn = null;
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
printLayout ('../pacientes/home.php', '../../../index.php', '../../citasmedicas/', 'diagnostico.php', 'facturas.php','../seguridad/controllers/logout.php','../seguridad/routes/perfil.php','../pacientes/home.php',3);
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
<center>
<table class="table" style="width: 1000px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Fecha de la cita</th>
      <th scope="col">Editar</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($citas as $Citas):
            if($Citas->tipo == 'Domicilio'):
      ?>
        <tr>
            <th scope="row"><?php echo $Citas->idcitas; ?>  </th>
            <td><?php echo $Citas->nombres; ?> </td>
            <td><?php echo $Citas->ape_paterno." ".$Citas->ape_mat; ?> </td>
            <td><?php echo $Citas->fecha; ?> </td>
            <td> <a href="../../citasmedicas/historial_clinico.php?id_paciente=<?php echo $Citas->idpacientes;?>&id_citas=<?php echo $Citas->idcitas;?> ">Ver</a></td>
        </tr>
    <?php 
            endif;
          endforeach; ?>
  </tbody>
</table>
</center>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../../recursoshumanos/components/scripts/dashboard.js"></script>  
</body>
</html>