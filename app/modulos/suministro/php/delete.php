<?php
    require '../../../../database.php';

    $id=$_GET["id"];
        if($_GET["proveedor"]==1){
            $sql = "DELETE FROM proveedores WHERE idproveedor=:idproveedor";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idproveedor', $id);
            $stmt->execute();
    
            echo "ELIMINADO";
        }else{
            $sql = "DELETE FROM productos WHERE idproducto=:idproducto";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idproducto', $id);
            $stmt->execute();
    
            echo "ELIMINADO";
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