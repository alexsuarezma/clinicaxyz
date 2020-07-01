<?php 
 date_default_timezone_set('AMERICA/GUAYAQUIL');
include "conexion.php";

$fecha_actual= date("Y-m-d");

$hora_actual=date("H-i-s");




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



    
 

?>


<html>
<head>
	<title>Citas</title>
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title></title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
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

<img src="logo1.png" style="width: 150px; height: 150px; position: relative; left: 50px;">

<h2 class="" style="text-align:center;">Citas Agendadas</h2>
<center>
	<table class="table table-striped" style="position: relative; top: 80px; width: 90%">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Cedula</th>
      <th scope="col">Fecha cita</th>
      <th scope="col">hora cita</th>
      <th scope="col">Especialidad</th>
      <th scope="col">Especialista</th>
      <th scope="col">Estado de la cita</th>
      <th scope="col">Editar</th>
      <th scope="col">Cancelar</th>
       <!--<th scope="col">Eliminar</th>  -->
    </tr>
  </thead>
  <tbody>

    <tr>
    <?php
  
    include "conexion.php";
    $sentencia="SELECT * FROM cita_medica where fecha='$fecha_actual' order by idcitas ";


$result=mysqli_query($conexion, $sentencia);
     while ($row = mysqli_fetch_array($result)){   
     	?>

	<th><?php echo $row['idcitas'] ?> </th>
    <th><?php echo $row['nombres'] ?> </th>
	<th><?php echo $row['ape_paterno']." ".$row['ape_mat'] ?> </th>
    <th><?php echo $row['idpacientes'] ?> </th>
    <th><?php echo $row['fecha'] ?> </th>
    <th><?php echo $row['hora'] ?> </th>
    <th><?php echo $row['descripcion'] ?> </th>
    <th><?php echo $row['nombreD']." ".$row['apellidos']; ?> </th>
    <th><?php echo $row['estado'] ?> </th>

    <?php 
    $id_paciente=$row['id_paciente'] ?? '';
    $id_cita=$row['idcitas'];

    
    if ($hora_actual>$row['hora']) {
    	
    	$sql_cambio="UPDATE citas
SET  estado='No realizado'
WHERe idcitas=$id_cita and estado='Pendiente'";

mysqli_query($conexion,$sql_cambio);
 }elseif ($hora_actual<$row['hora']) {
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

<?php }elseif ($row['estado']=='Realizado') {
	# code...
	?>

	<th> <a href="cambiar_estado.php?paciente=<?php echo $id_cita ?> " > <img src="anular.jpg" style="width: 30px; height: 20px; border-radius:50px;"></a> </th>
    <th><button type="button" name="" id="" class="btn btn-danger"  onClick="return preguntar(<?php echo $row['idcitas']; ?>)"> Cancelar</button></th>
<?php }elseif ($row['estado']=='No realizado') { ?>
	
	<th> <a href onclick="alert('Cita no realizada');"> <img src="no_rea.png" style="width: 30px; height: 20px; border-radius:50px;"></a> </th>
   <th><button type="button" name="" id="" class="btn btn-danger"  onClick="return preguntar(<?php echo $row['idcitas']; ?>)"> Cancelar</button></th>
<?php	}elseif ($row['estado']=='Cancelado' ) { ?>
  
  <th> Cita cancelada</th>


	<!--<th> <a href=""> <img src="eliminar.png" style="width: 30px; height: 20px; border-radius: 50px;"></a> </th> -->
  

  <th>Cancelada</th>
<?php } ?>
  </tr>
<?php }   ?>   


  </tbody>
</table>
</center>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>