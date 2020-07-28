<?php
echo $_POST['idProduct'];

require '../../../../database.php';


$sql = "UPDATE productos SET deleted=:deleted WHERE idproducto=:idproducto";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
$stmt->bindParam(':idproducto', $_POST['idProduct']);

if($stmt->execute()){

    $sql = "UPDATE producto_has_proveedor SET deleted=:deleted WHERE idproducto_has=:idproducto_has";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':deleted', 0, PDO::PARAM_INT);
    $stmt->bindParam(':idproducto_has', $_POST['idProduct']);

    if($stmt->execute()){
        header("Location:../routes/informacionProducto.php?id=".$_POST['idProduct']);
    }
}