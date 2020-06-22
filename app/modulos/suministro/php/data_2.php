<?php

require 'conexion.php';

$identificacion_provee= $_POST["numero_identificacion_pro"];
$razon_social_provee= $_POST["razon_social_empresa_pro"];
$nombre_proveedor_provee= $_POST["nombre_representante_legal_pro"];  
$direccion_provee= $_POST["direccion_pro"];
$ciudad_provee= $_POST["ciudad_pro"];
$telefono_provee= $_POST["telefono_1_pro"]; 
$telefono_provee_2= $_POST["telefono_2_pro"]; 
$email_provee_1= $_POST["email_1_pro"];
$email_provee_2= $_POST["email_2_pro"];



$consulta="INSERT INTO proveedor (numero_identificacion_pro,razon_social_empresa_pro,nombre_representante_legal_pro,direccion_pro,ciudad_pro,telefono_1_pro,telefono_2_pro,email_1_pro,email_2_pro) VALUES ('$identificacion_provee','$razon_social_provee','$nombre_proveedor_provee','$direccion_provee','$ciudad_provee','$telefono_provee','$telefono_provee_2','$email_provee_1,'$email_provee_2')";

$resultado = mysqli_query($conexion,$consulta);

if($resultado){
    echo "Insertado";    
}else{
    var_dump($conexion);
    // var_dump($conexion);
}

?>
