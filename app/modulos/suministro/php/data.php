<?php

require 'conexion.php';


$serie_pro= $_POST['codigo_barra_pr'];
$nombre_pro= $_POST['nombre_pr'];
$descripcion_pro= $_POST['descripcion_pr'];
$stock_pro= $_POST['stock_pr'];
$valor_pro= $_POST['precio_pr'];
$fecha_elaboracion_pro= $_POST['fecha_elaboracion_pr'];
$fecha_caducidad_pro= $_POST['fecha_caducidad_pr'];


$consulta="INSERT INTO productos (codigo_barra_pr, nombre_pr, descripcion_pr, stock_pr, precio_pr, fecha_elaboracion_pr, fecha_caducidad_pr) VALUES ('$serie_pro', '$nombre_pro', '$descripcion_pro', '$stock_pro', '$valor_pro', '$fecha_elaboracion_pro', '$fecha_caducidad_pro')";
// $conexion->query(,$consulta);

$resultado= mysqli_query($conexion,$consulta);

if($resultado){
    echo "Insertado";    
}else{
}
?>