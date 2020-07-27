<?php
require '../../../../database.php';


$sql = "UPDATE productos SET deleted=:deleted WHERE idproducto=:idproducto";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':deleted', 1, PDO::PARAM_INT);
$stmt->bindParam(':idproducto', $_POST['idProduct']);

if($stmt->execute()){
    //SE QUITA EL PRODUCTO PRODUC_HAS_PROVE
    $sql = "UPDATE producto_has_proveedor SET deleted=:deleted WHERE idproducto_has=:idproducto_has";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':deleted', 1, PDO::PARAM_INT);
    $stmt->bindParam(':idproducto_has', $_POST['idProduct']);
    if($stmt->execute()){
        header("Location:../routes/productos.php");
    }
}