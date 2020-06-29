<?php

require 'conexion.php';


$serie_pro= $_POST['serie'];
$nombre_pro= $_POST['nombre'];
$descripcion_pro= $_POST['descripcion'];
$categoria_pro= $_POST['categoria'];
$stock_pro= $_POST['stock'];
$canal_distribucion_pro= $_POST['canal_distribucion'];
$valor_pro= $_POST['valor'];
$fecha_elaboracion_pro= $_POST['fecha_elaboracion'];
$fecha_caducidad_pro= $_POST['fecha_caducidad'];


$consulta="INSERT INTO product
(`id_proveedor`,
	serie, 
 nombre, 
 descripcion, 
 categoria, 
 stock, 
 canal_distribucion, 
 valor, 
 fecha_elaboracion, 
 fecha_caducidad) 
VALUES      (1,
'".$serie_pro."', 
 '".$nombre_pro."', 
 '".$descripcion_pro."', 
 '".$categoria_pro."', 
 ".$stock_pro.", 
 '".$canal_distribucion_pro."', 
 ".$valor_pro.", 
 '".$fecha_elaboracion_pro."', 
 '".$fecha_caducidad_pro."')";

$resultado= mysqli_query($conexion,$consulta) or die ("NO GUARDADO");


?>