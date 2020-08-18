<?php

require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

$sql = "INSERT INTO proveedores (numero_identificacion_pro,razon_social_empresa_pro,nombre_representante_legal_pro,direccion_pro,ciudad_pro,telefono_1_pro,telefono_2_pro,email_1_pro,email_2_pro,deleted) VALUES 
(:numero_identificacion_pro,:razon_social_empresa_pro,:nombre_representante_legal_pro,:direccion_pro,:ciudad_pro,:telefono_1_pro,:telefono_2_pro,:email_1_pro,:email_2_pro,:deleted)";                    
$stmt = $conn->prepare($sql);                              
$stmt->bindParam(':numero_identificacion_pro',$_POST['numeroIdentificacion']);
$stmt->bindParam(':razon_social_empresa_pro',$_POST['razonSocial']);
$stmt->bindParam(':nombre_representante_legal_pro',$_POST['nombreRepresentante']);
$stmt->bindParam(':direccion_pro',$_POST['direccionProveedor']);
$stmt->bindParam(':ciudad_pro', $_POST['ciudad']);
$stmt->bindParam(':telefono_1_pro', $_POST['telefonoUno']);
$stmt->bindParam(':telefono_2_pro', $_POST['telefonoDos']);
$stmt->bindParam(':email_1_pro', $_POST['emailUno']);
$stmt->bindParam(':email_2_pro', $_POST['emailDos']);
$stmt->bindValue(':deleted', 0, PDO::PARAM_INT);

if($stmt->execute()){
    $auditoria = new Auditoria(utf8_decode('Registro'), 'Suministros',utf8_decode("Se registro un nuevo proveedor ".$_POST['razonSocial']),$_SESSION['user_id'],null);
    $auditoria->Registro($conn);
    header("Location:../routes/proveedores.php");
}

