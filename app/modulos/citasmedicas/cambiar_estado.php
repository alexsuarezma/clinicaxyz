<?php

include 'conexion.php';


$id_paciente=$_GET['paciente'];

$sql="SELECT * from citas where idcitas=$id_paciente";
$resultado=mysqli_query($conexion,$sql);
$row=mysqli_fetch_array($resultado);


if ($row['estado']=='Pendiente') {
	# code...


$sql_cambio="UPDATE citas
SET  estado='Realizado'
WHERe idcitas=$id_paciente ";
 } elseif ($row['estado']=='Realizado') {
 	$sql_cambio="UPDATE citas
SET  estado='Pendiente'
WHERe idcitas=$id_paciente ";
 }

mysqli_query($conexion,$sql_cambio);


  echo ("<script LANGUAGE='JavaScript'>
    window.alert('Cambio modificado con exito!!  ');
    window.location.href='citas.php';
    </script>");



?>