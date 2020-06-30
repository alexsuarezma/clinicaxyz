<?php

require '../../../../database.php';
$id = $_POST['idproveedor'];

$sql = "UPDATE proveedores SET numero_identificacion_pro=:numero_identificacion_pro,razon_social_empresa_pro=:razon_social_empresa_pro,nombre_representante_legal_pro=:nombre_representante_legal_pro,direccion_pro=:direccion_pro,
ciudad_pro=:ciudad_pro,telefono_1_pro=:telefono_1_pro,telefono_2_pro=:telefono_2_pro,email_1_pro=:email_1_pro,email_2_pro=:email_2_pro WHERE idproveedor=:idproveedor";
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
$stmt->bindParam(':idproveedor', $id);

        if($stmt->execute()){
            echo "DATO ACTUALIZADO CORRECTAMENTE";
        }else{
            echo "DATO NO GUARDADO";
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta http-equiv="refresh" content="2;URL=buscarProveedores.php?p=<?php echo $id;?>">
    <title>Document</title>
</head>
<body>
    
</body>
</html>