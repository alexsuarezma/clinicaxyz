<?php
var_dump($_POST['precioPvp']);
var_dump($_POST['idproductoInv']);

require '../../../../database.php';

$sql = "UPDATE inventario_productos SET precio_unitario_pvp=:precio_unitario_pvp WHERE idproducto_inventario=:idproducto_inventario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':precio_unitario_pvp',$_POST['precioPvp']);
$stmt->bindParam(':idproducto_inventario', $_POST['idproductoInv']);

    if($stmt->execute()){
        header("Location:../routes/inventario.php");
    }