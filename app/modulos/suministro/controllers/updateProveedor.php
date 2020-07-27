<?php

require '../../../../database.php';


$sql = "UPDATE proveedores SET numero_identificacion_pro=:numero_identificacion_pro,razon_social_empresa_pro=:razon_social_empresa_pro,nombre_representante_legal_pro=:nombre_representante_legal_pro,direccion_pro=:direccion_pro,
ciudad_pro=:ciudad_pro,telefono_1_pro=:telefono_1_pro,telefono_2_pro=:telefono_2_pro,email_1_pro=:email_1_pro,email_2_pro=:email_2_pro WHERE idproveedor=:idproveedor";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':numero_identificacion_pro',$_POST['numeroIdentificacionEdit']);
$stmt->bindParam(':razon_social_empresa_pro',$_POST['razonSocialEdit']);
$stmt->bindParam(':nombre_representante_legal_pro',$_POST['nombreRepresentanteEdit']);
$stmt->bindParam(':direccion_pro',$_POST['direccionProveedorEdit']);
$stmt->bindParam(':ciudad_pro', $_POST['ciudadEdit']);
$stmt->bindParam(':telefono_1_pro', $_POST['telefonoUnoEdit']);
$stmt->bindParam(':telefono_2_pro', $_POST['telefonoDosEdit']);
$stmt->bindParam(':email_1_pro', $_POST['emailUnoEdit']);
$stmt->bindParam(':email_2_pro', $_POST['emailDosEdit']);
$stmt->bindParam(':idproveedor', $_POST['idProveedorEdit']);

if($stmt->execute()){
    header("Location:../routes/proveedores.php");
}
