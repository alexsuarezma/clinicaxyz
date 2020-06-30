<?php

require '../../../../database.php';

// $identificacion_provee= $_POST["identificacion"];
// $numero_identificacion_provee= $_POST["numero_identificacion"];
// $nombre_proveedor_provee= $_POST["nombre_proveedor"];  
// $ciudad_provee= $_POST["ciudad"];
// $direccion_provee= $_POST["direccion"];
// $telefono_provee= $_POST["telefono"]; 
// $email_provee= $_POST["email"];


// $consulta="INSERT INTO proveedor (identificacion,numero_identificacion,nombre_proveedor,ciudad,direccion,telefono,email) VALUES ('$identificacion_provee','$numero_identificacion_provee','$nombre_proveedor_provee','$ciudad_provee','$direccion_provee','$telefono_provee','$email_provee')";

// $resultado= mysqli_query($conexion,$consulta)  or die ("NO GUARDADO");


$sql = "INSERT INTO proveedores (numero_identificacion_pro,razon_social_empresa_pro,nombre_representante_legal_pro,direccion_pro,ciudad_pro,telefono_1_pro,telefono_2_pro,email_1_pro,email_2_pro) VALUES 
(:numero_identificacion_pro,:razon_social_empresa_pro,:nombre_representante_legal_pro,:direccion_pro,:ciudad_pro,:telefono_1_pro,:telefono_2_pro,:email_1_pro,:email_2_pro)";                    
$stmt = $conn->prepare($sql);                              
$stmt->bindParam(':numero_identificacion_pro',$_POST['numero_identificacion_pro']);
$stmt->bindParam(':razon_social_empresa_pro',$_POST['razon_social_empresa_pro']);
$stmt->bindParam(':nombre_representante_legal_pro',$_POST['nombre_representante_legal_pro']);
$stmt->bindParam(':direccion_pro',$_POST['direccion_pro']);
$stmt->bindParam(':ciudad_pro', $_POST['ciudad']);
$stmt->bindParam(':telefono_1_pro', $_POST['telefono_1_pro']);
$stmt->bindParam(':telefono_2_pro', $_POST['telefono_2_pro']);
$stmt->bindParam(':email_1_pro', $_POST['email_1_pro']);
$stmt->bindParam(':email_2_pro', $_POST['email_2_pro']);
if($stmt->execute()){
    echo "DATO GUARDADO CORRECTAMENTE";
}else{
    echo "DATO NO GUARDADO";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="refresh" content="2;URL=../">
<title>Document</title>
</head>
<body>

</body>
</html>