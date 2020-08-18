<?php
echo $_POST['idProveedor'];


require '../../../../database.php';
require '../../seguridad/controllers/functions/Auditoria.php';

session_start();

$proveedor = $conn->query("SELECT * FROM proveedores WHERE idproveedor=".$_POST['idProveedor'])->fetchAll(PDO::FETCH_OBJ);

$sql = "UPDATE proveedores SET deleted=:deleted WHERE idproveedor=:idproveedor";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
$stmt->bindParam(':idproveedor', $_POST['idProveedor']);

if($stmt->execute()){

    $sql = "UPDATE producto_has_proveedor SET deleted=:deleted WHERE idproveedor_has=:idproveedor_has";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
    $stmt->bindParam(':idproveedor_has', $_POST['idProveedor']);

    if($stmt->execute()){
        $auditoria = new Auditoria(utf8_decode('Registro'), 'Suministros',utf8_decode("Se volvio a publicar un proveedor dado de baja: ".$proveedor[0]->razon_social_empresa_pro),$_SESSION['user_id'],null);
        $auditoria->Registro($conn);
        header("Location:../routes/proveedores.php");
    }
}