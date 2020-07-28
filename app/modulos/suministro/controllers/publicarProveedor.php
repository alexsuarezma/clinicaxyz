<?php
echo $_POST['idProveedor'];


require '../../../../database.php';


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
        header("Location:../routes/proveedores.php");
    }
}