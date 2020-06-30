<?php
    require '../../../../database.php';

    $id=$_GET["id"];
               
        $sql = "DELETE FROM productos WHERE idproducto=:idproducto";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idproducto', $id);
        $stmt->execute();

        echo "ELIMINADO";