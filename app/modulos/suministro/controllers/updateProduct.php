<?php

require '../../../../database.php';

$sql = "UPDATE productos SET codigo_barra_pr=:codigo_barra_pr,nombre_pr=:nombre_pr,descripcion_pr=:descripcion_pr,precio_unitario_pr=:precio_unitario_pr,fecha_elaboracion_pr=:fecha_elaboracion_pr,fecha_caducidad_pr=:fecha_caducidad_pr,idcategoria_pr=:idcategoria_pr WHERE idproducto=:idproducto";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':codigo_barra_pr',$_POST['codigoBarra']);
$stmt->bindParam(':nombre_pr',$_POST['nombreProducto']);
$stmt->bindParam(':descripcion_pr',$_POST['descripcion']);
$stmt->bindParam(':precio_unitario_pr', $_POST['precio']);
$stmt->bindParam(':fecha_elaboracion_pr', $_POST['fechaElaboracion']);
$stmt->bindParam(':fecha_caducidad_pr', $_POST['fechaCaducidad']);
$stmt->bindParam(':idcategoria_pr', $_POST['categoria']);
$stmt->bindParam(':idproducto', $_POST['idproducto']);

        if($stmt->execute()){
            header("Location:../routes/productos.php");
        }