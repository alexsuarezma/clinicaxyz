<?php

require 'conexion.php';

$identificacion_provee= $_POST["identificacion"];
$numero_identificacion_provee= $_POST["numero_identificacion"];
$nombre_proveedor_provee= $_POST["nombre_proveedor"];  
$ciudad_provee= $_POST["ciudad"];
$direccion_provee= $_POST["direccion"];
$telefono_provee= $_POST["telefono"]; 
$email_provee= $_POST["email"];


$consulta="INSERT INTO proveedor (identificacion,numero_identificacion,nombre_proveedor,ciudad,direccion,telefono,email) VALUES ('$identificacion_provee','$numero_identificacion_provee','$nombre_proveedor_provee','$ciudad_provee','$direccion_provee','$telefono_provee','$email_provee')";

$resultado= mysqli_query($conexion,$consulta)  or die ("NO GUARDADO");

?>
